<?php

/**
 * Created by PhpStorm.
 * User: mannv
 * Date: 1/19/2017
 * Time: 3:33 PM
 */
namespace Kayac\Sheet;
class SheetReader
{
    /**
     * @var Google_Service_Sheets
     */
    private $_service = null;

    function __construct()
    {
    }

    /**
     * @param $spreadsheetId
     * VD: 1uZ6czXs48hERfZaVGlHgQ9Y7yb3FsjKgbL_iclEV8qQ
     * @param $range
     * VD: Achievement!A2:D
     * @return mixed
     * $spreadsheetId = '';
     */
    function reader($spreadsheetId, $range)
    {
        if ($this->_service == null) {
            // Get the API client and construct the service object.
            $client = $this->getClient();
            $this->_service = new \Google_Service_Sheets($client);
        }

        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $response = $this->_service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    private function getClient()
    {
        $scopes = implode(' ', array(\Google_Service_Sheets::SPREADSHEETS_READONLY));

        $client = new \Google_Client();
        $client->setApplicationName(config('google.APPLICATION_NAME'));
        $client->setScopes($scopes);
        $client->setAuthConfig(config('google.CLIENT_SECRET_PATH'));
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = $this->expandHomeDirectory(config('google.CREDENTIALS_PATH'));
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    private function expandHomeDirectory($path)
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }

}