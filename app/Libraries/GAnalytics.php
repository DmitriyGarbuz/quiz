<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GAnalytics - Google Analytics PHP Interface for Code Igniter
 * Uses google php api https://github.com/google/google-api-php-client
 *
 * Support material:
 * How to set-up the app and configure the analytics profile http://stackoverflow.com/a/10089698/1666071
 * Analytics query explorer http://ga-dev-tools.appspot.com/explorer/
 *  
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Iacami Gevaerd <enapupe@gmail.com>
 * @version 1
 * 
 */

class GAnalytics {
    private $client;
    private $service;
	
    public function __construct(){
        set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH.'ThirdParty/');
        require_once(APPPATH . 'ThirdParty/Google/Client.php');
        require_once(APPPATH . 'ThirdParty/Google/Service/Analytics.php');
    }
    public function setup($app_name, $credentials){
        // create client object and set app name
        $this->client = new Google_Client();
        $this->client->setApplicationName($app_name); // name of your app
        // set assertion credentials
        $this->client->setAssertionCredentials(
            new Google_Auth_AssertionCredentials(
                $credentials['email'], // email you added to GA
                array('https://www.googleapis.com/auth/analytics.readonly'),
                $credentials['key']  // keyfile you downloaded
        ));
        // other settings
        $this->client->setClientId($credentials['client_id']);// from API console
        $this->client->setAccessType('offline_access');// this may be unnecessary?
        // create service and get data
        $this->service = new Google_Service_Analytics($this->client);
    }
    public function data($ids, $startDate, $endDate, $metrics, $optParams = array()){
        return $this->service->data_ga->get($ids, $startDate, $endDate, $metrics, $optParams);
    }
}
/* End of file application/libraries/GAnalytics.php */