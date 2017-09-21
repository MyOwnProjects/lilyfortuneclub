<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Tools extends Account_base_controller {
	private $interest_history = array(
		1928 => 43.81, 1929 => -8.30, 1930 => -25.12, 1931 => -43.84, 1932 => -8.64, 
		1933 => 49.98, 1934 => -1.19, 1935 => 46.74, 1936 => 31.94, 1937 => -35.34, 
		1938 => 29.28, 1939 => -1.10, 1940 => -10.67, 1941 => -12.77, 1942 => 19.17, 
		1943 => 25.06, 1944 => 19.03, 1945 => 35.82, 1946 => -8.43, 1947 => 5.20, 
		1948 => 5.70, 1949 => 18.30, 1950 => 30.81, 1951 => 23.68, 1952 => 18.15, 
		1953 => -1.21, 1954 => 52.56, 1955 => 32.60, 1956 => 7.44, 1957 => -10.46, 
		1958 => 43.72, 1959 => 12.06, 1960 => 0.34, 1961 => 26.64, 1962 => -8.81, 
		1963 => 22.61, 1964 => 16.42, 1965 => 12.40, 1966 => -9.97, 1967 => 23.80, 
		1968 => 10.81, 1969 => -8.24, 1970 => 3.56, 1971 => 14.22, 1972 => 18.76, 
		1973 => -14.31, 1974 => -25.90, 1975 => 37.00, 1976 => 23.83, 1977 => -6.98, 
		1978 => 6.51, 1979 => 18.52, 1980 => 31.74, 1981 => -4.70, 1982 => 20.42, 
		1983 => 22.34, 1984 => 6.15, 1985 => 31.24, 1986 => 18.49, 1987 => 5.81, 
		1988 => 16.54, 1989 => 31.48, 1990 => -3.06, 1991 => 30.23, 1992 => 7.49, 
		1993 => 9.97, 1994 => 1.33, 1995 => 37.20, 1996 => 22.68, 1997 => 33.10, 
		1998 => 28.34, 1999 => 20.89, 2000 => -9.03, 2001 => -11.85, 2002 => -21.97, 
		2003 => 28.36, 2004 => 10.74, 2005 => 4.83, 2006 => 15.61, 2007 => 5.48, 
		2008 => -36.55, 2009 => 25.94, 2010 => 14.82, 2011 => 2.10, 2012 => 15.89, 
		2013 => 32.15, 2014 => 13.52, 2015 => 1.38, 2016 => 11.74
	);

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load_view('tools', array('interest_history' => $this->interest_history));
	}
	
	private function illustration_data(){
		$data = array();
		$post = $this->input->post();
		$tax_income_raw = $this->input->post('tax-rate-income');
		$tax_investment_raw = $this->input->post('tax-rate-investment');
		$applied_interest_list_raw = $this->input->post('applied-interest');
		$deposit_tax_free_raw = $this->input->post('deposit-tax-free');
		$deposit_tax_defer_raw = $this->input->post('deposit-tax-defer');
		$deposit_tax_now_raw = $this->input->post('deposit-tax-now');
		$current_age = $this->input->post('current-age');
		$end_age = $this->input->post('end-age');
		$ltc_age_start = $this->input->post('ltc-age-start');
		$ltc_years = $this->input->post('ltc-years');
		$withdraw_living = $this->input->post('withdraw-living'); 

		$interest_year_start = $this->input->post('interest-year-start');
		$loop_year_start = $this->input->post('loop-year-start');
		$inflation = $this->input->post('inflation');
		$retirement_age = $this->input->post('retirement-age');
		$withdraw_ltc = $this->input->post('withdraw-ltc');
		$floor_caps = $this->input->post('floor-caps') == 'Y';
		
		//var_dump($tax_income_raw);
		//echo 123;print_r($post);exit;
		
		$tax_investment = array();
		$tax_income = array();
		$deposit_tax_now = array();
		$deposit_tax_defer = array();
		$deposit_tax_free = array();
		$applied_interest_list = array();
		for($i = $current_age; $i <= $end_age; ++$i){
			if($tax_income_raw){
					$tax_investment[$i] = floatval($tax_investment_raw[$i - $current_age]);
					$tax_income[$i] = floatval($tax_income_raw[$i - $current_age]);
					if($applied_interest_list_raw[$i - $current_age] !== ''){
						$applied_interest_list[$i] = floatval($applied_interest_list_raw[$i - $current_age]);
					}
					$deposit_tax_now[$i] = intval($deposit_tax_now_raw[$i - $current_age]); 
					$deposit_tax_defer[$i] = intval($deposit_tax_defer_raw[$i - $current_age]); 
					$deposit_tax_free[$i] = intval($deposit_tax_free_raw[$i - $current_age]); 
			}
			else{
					$tax_investment[$i] = 20;
					$tax_income[$i] = 30;
					$deposit_tax_now[$i] = 0; 
					$deposit_tax_defer[$i] = 0; 
					$deposit_tax_free[$i] = 0;
			}
		}
		$balance_tax_now = 0;
		$balance_tax_defer = 0; 
		$balance_tax_free = 0; 
		
		$k = array_keys($this->interest_history);
        $last_year = end($k);
			
		$balance_now_begin = $balance_tax_now;
		$balance_defer_begin = $balance_tax_defer;
		$balance_free_begin = $balance_tax_free;
		$income_tax = 0;
		$interest_year = $interest_year_start; 
		for($age = $current_age; $age <= $end_age; ++$age){
			if($interest_year > $last_year){
				$interest_year = $loop_year_start;
			}
			$interest_percent = $this->interest_history[$interest_year];
			if($applied_interest_list && array_key_exists($age, $applied_interest_list)){
				$interest = $applied_interest_list[$age] / 100;
			}
			else{
				$interest = $interest_percent / 100;
			}
			if($floor_caps){
				if($interest < 0.0075){
					$interest = 0.0075;
				}
				else if($interest > 0.135){
					$interest = 0.135;
				}
			}
			
			$balance_now_end = $balance_now_begin + $deposit_tax_now[$age];
			$balance_defer_end = $balance_defer_begin + $deposit_tax_defer[$age];
			$balance_free_end = $balance_free_begin + $deposit_tax_free[$age];

			$total_withdraw = 0;
			$tax_now_gain = ($balance_now_end) * $interest;
			$tax_defer_gain = ($balance_defer_end) * $interest;
			$tax_free_gain = ($balance_free_end) * $interest;
			
			if($tax_now_gain >= 0){
				$invest_tax_amount = $tax_now_gain * ($tax_investment[$age] / 100);
				$tax_now_gain -= $invest_tax_amount;
			}
			else{
				$invest_tax_amount = 0;
			}

			if($age >= $retirement_age){//can work
				$total_withdraw += $withdraw_living;
			}
			if($age >= $ltc_age_start && $age < $ltc_age_start + $ltc_years){//LTC
				//LTC withdraw
				$total_withdraw += $withdraw_ltc;
			}
			
			/*if($age == 70 && $balance_defer_end > 0){
				$balance_defer_end = 0;
				$total_withdraw -= $balance_defer_end * (1 - $tax_income[$age] / 100);
				$income_tax = $balance_defer_end * ($tax_income[$age] / 100);
			}*/
			//echo $balance_now_end.' '.$tax_now_gain;exit;
			$balance_now_end += $tax_now_gain;
			$balance_defer_end += $tax_defer_gain;
			$balance_free_end += $tax_free_gain;
			if($total_withdraw > 0){
				if($total_withdraw <= $balance_free_end){
					$balance_free_end -= $total_withdraw;
				}
				else{
					if($total_withdraw - $balance_free_end <= $balance_now_end){
						$balance_now_end -= $total_withdraw - $balance_free_end;
					}
					else{
						$before_tax_withdraw = ($total_withdraw - $balance_free_end - $balance_now_end) / (1 - $tax_income[$age] / 100);
						$income_tax = $before_tax_withdraw * ($tax_income[$age] / 100);
						$balance_defer_end -= $before_tax_withdraw;
						$balance_now_end = 0;
					}
					$balance_free_end = 0;
				}
			}
			
			$data[$age] = array(
				'balance-total-begin' => $balance_now_begin + $balance_defer_begin + $balance_free_begin,
				'balance-now-begin' => $balance_now_begin, 
				'balance-defer-begin' => $balance_defer_begin, 0, 
				'balance-free-begin' => $balance_free_begin, 0, 
				'deposit-tax-now' => $deposit_tax_now[$age], 
				'deposit-tax-defer' => $deposit_tax_defer[$age], 
				'deposit-tax-free' => $deposit_tax_free[$age],
				'historical-interest' => $interest_percent, 
				'applied-interest' => $applied_interest_list && array_key_exists($age, $applied_interest_list) ? $applied_interest_list[$age] : null,
				'tax-rate-investment' => $tax_investment[$age], 
				'tax-amount-investment' => $invest_tax_amount, 
				'tax-rate-income' => $tax_income[$age], 
				'tax-amount-income' => $income_tax,	
				'withdraw-living' => $age >= $retirement_age ? $withdraw_living : 0, 
				'withdraw-ltc' => $age >= $ltc_age_start && $age < $ltc_age_start + $ltc_years ? $withdraw_ltc : 0,	
				'balance-now-end' => $balance_now_end, 
				'balance-defer-end' => $balance_defer_end, 
				'balance-free-end' => $balance_free_end, 
				'balance-total-end' => $balance_now_end + $balance_defer_end + $balance_free_end
			);
			$balance_now_begin = $balance_now_end;
			$balance_defer_begin = $balance_defer_end;
			$balance_free_begin = $balance_free_end;
			$withdraw_living *= 1 + $inflation / 100;
			$withdraw_ltc *= 1 + $inflation / 100;
			++$interest_year;
		}
		return $data;
	}

	public function illustration_report(){
		$data = $this->illustration_data();
		echo json_encode($data);
	}
	
	public function illustration_export(){
		$data = $this->illustration_data();
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="illustration.csv";');
		$f = fopen('php://output', 'w');
		fputcsv($f, array('Age', 'Year Begin Balance Total', 'Year Begin Balance Tax Now', 'Year Begin Balance Tax Defer', 
			'Year Begin Balance Tax Free', 'Deposit to Account Tax Now', 'Deposit to Account Tax Defer', 'Deposit to Account Tax Free',
			'Gain Interest Historical',	'Gain Interest Applied', 'Investment Tax Rate', 'Investment Tax Amount',
			'Income	Tax Rate', 'Income Tax Amount', 'Living Expense', 'LTC Expense', 'Year End Balance Total', 
			'Year End Balance Tax Now', 'Year End Balance Tax Defer', 'Year End Balance Tax Free'
		));
		foreach ($data as $line) {
			fputcsv($f, $line);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */