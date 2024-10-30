<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin's Util Class 
 * @package live-covid
 * @author Chandan Kumar
 * @version 1.0.0
 */


if( !class_exists('LCOVID_Utils') ){

	class LCOVID_Utils{
		
		/**
		* Entire data from API
		* @var array
		*/
		private $full_data;

		/**
		* Current Version of the Plugin
		* @var string
		*/
		const PLUGIN_V = LIVE_COVID_LTE_VERSION;

		/**
		* API URL for COVID19 Data 
		* @var string
		*/
		public $api_url;
		
		/**
		* Which data can be fetch store to site transient
		* `key` => data store to site transient by these string
		* `value` => Data available in api by these string 
		* @var array
		*/
		protected $def_args = [ 'country'=> 'country', 'countryInfo' => 'countryInfo',  'confirms' => 'cases', 'deaths' => 'deaths', 'recovered' => 'recovered'];

		/**
		* Default Arguments for All Cases
		* Helps to get only `confirms` , `deaths`, `recovered` cases for World Data
		* @var array
		*/
		protected $world_args = [ 'confirms','deaths', 'recovered'];

		/**
		* Sort the Data only through these cases
		* @var array
		*/
		private $sorts = [ 'confirms', 'deaths', 'recovered'];


		/**
		* Class constructor
		*/
		public function __construct($args = null) {

			// Set the API Url 
			$this->set_api();

			// Set the Data 
			$this->set_data();
		}

		/**
		* Set the COVID19 data to site transient ( lcovid_data_{plugin_version} )
		*
		* To renew the data in evenrty 10 minutes, another transient ( lcovid_data_exp_{plugin_version} ) is available to check timeframe, if it expire then restore the covid-19 data and expiration time in transient for another 10 minutes.
		* 
		* @since 1.0.0
		*
		* @access public
		*/
		private function set_data(){

			// Check the expiration of data
			if( false === get_transient( 'lcovid_data_exp'.self::PLUGIN_V )){

				// Get all countries dat from API
				$data = $this->cUrl($this->api_url.'countries');

				// Check if the proper data couldn't fetched
				if( !is_array($data) || empty($data)) 
					$this->full_data = get_transient( 'lcovid_data'.self::PLUGIN_V );
				
				// Rearrange the data
				$data = $this->setArray( $data ); 

				// Check if Data is exists
				if( !empty($data) ){
					set_transient( 'lcovid_data'.self::PLUGIN_V, $data );
					$this->full_data = $data;
				}else{
					$this->full_data = get_transient( 'lcovid_data'.self::PLUGIN_V );
				}

				// Renew the expire time to another 10 minutes
				set_transient( 'lcovid_data_exp'.self::PLUGIN_V, 'yes', 600 );	
			}else{

				// Assign the data from transient
				$this->full_data = get_transient( 'lcovid_data'.self::PLUGIN_V );
			}
		}


		/**
		* Set API URL to fetch the data of covid19
		*
		* In default, this plugin sets 3rd party api for covid19 data which is available in github  
		* This API have only get requests, So the api can't get any data from the site 
		*
		* @link https://github.com/NovelCOVID/API
		*
		* @access private
		*/
		private function set_api(){
			$this->api_url = 'https://corona.lmao.ninja/v2/';
		}

		/****************************
		* Arrange List
		****************************/

		private function setArray( $data = array() ){
			$arr = [];
			foreach ($data as $val) {
				if( isset($val['countryInfo']['iso3']) && $val['countryInfo']['iso3'])
					$code = $val['countryInfo']['iso3'];
				else
					$code = 'ship-'.str_replace (" ", "-", $val['country']);
				$arr[ $code ] = $this->replace_key( $val );
			}
			return $arr;
		}

		protected function replace_key( $data ){
			$cases = [];
			foreach ($this->def_args as $key => $val) {
					$cases[$key] = $data[$val];
			}
			return $cases;
		}

		public function sortData($array,$elem,$order='dsc'){
			usort($array, function($a,$b) use($elem,$order){
				if($order=='dsc')
					return ($a[$elem] >= $b[$elem]) ? -1 : 1;
				else
					return ($a[$elem] <= $b[$elem]) ? -1 : 1;
			});
			return $array;
		}

		/****************************
		* Get Data
		****************************/

		public function getCountry_data( $iso3 ){
			if( !empty($this->full_data) ){
				return ( isset($this->full_data[$iso3]) ) ? $this->full_data[$iso3] : array();
			}
		}

		public function getWorld_data(){
			$arr = [];
			if( !empty($this->full_data) ){
				foreach ($this->world_args as  $val) {
					$column = array_column( $this->full_data , $val );
					$arr[$val] = array_sum( array_column( $this->full_data , $val ) );

				}
			}
			return $arr;
		}

		public function getAllCountry_data( $args = array() ){
			$arr = [];
			if( !empty($this->full_data) ){
				if( isset($args['sort']) && in_array($args['sort'], $this->sorts)){
					$arr = $this->sortData( $this->full_data, $args['sort'] );
				}else{
					$arr = $this->full_data;
				}
			}
			return $arr;
		}

		public static function CountryList(){
			$countries = [];
			$self = new self(); 
			$alldata = $self->full_data;
			if(!empty($alldata)){
				foreach ($alldata as $val) {
					if(isset($val['countryInfo']['iso3']) && ($val['countryInfo']['iso3']) )
						$countries[ $val['countryInfo']['iso3'] ] = $val['country'];
				}
			}
			asort($countries);
			return $countries;
		}

		/****************************
		* Fetch Data
		****************************/

		/**
		* Fetch Data from API
		* 
		* @since 1.0.0
		*
		* @access public
		*
		* @param string $url (API URL)
		*
		* @return array result from api
		*/
		public function cUrl($url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$data = curl_exec($curl);
			curl_close($curl);
			return json_decode( $data, true );
		}

	}
}

?>
