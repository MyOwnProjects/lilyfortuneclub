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
	
	public function illustration_report(){
		$data = array();
		$post = $this->input->post();
		$interest_year_start = $this->input->post('interest-year-start');
		$tax_investment = $this->input->post('tax-investment');
		$tax_income = $this->input->post('tax-income');
		$inflation = $this->input->post('inflation');
		$current_age = $this->input->post('current-age');
		$end_age = $this->input->post('end-age');
		$total_years = $end_age - $current_age + 1;
		$retirement_age = $this->input->post('retirement-age');
		$ltc_age_start = $this->input->post('ltc-age-start');
		$ltc_years = $this->input->post('ltc-years');
		$balance_tax_now = $this->input->post('balance-tax-now'); 
		$balance_tax_defer = $this->input->post('balance-tax-defer'); 
		$balance_tax_free = $this->input->post('balance-tax-free'); 
		$deposit_tax_now = $this->input->post('deposit-tax-now'); 
		$deposit_tax_defer = $this->input->post('deposit-tax-defer'); 
		$deposit_tax_free = $this->input->post('deposit-tax-free'); 
		$withdraw_living = $this->input->post('withdraw-living'); 
		$withdraw_ltc = $this->input->post('withdraw-ltc');
		$modified_interest_list = $this->input->post('modified-interest-list');
		
		$index = array_search($interest_year_start,array_keys($this->interest_history));
		if(count($this->interest_history) - $index < $total_years){
			echo json_encode(array('error' => "Error! The number of interest years is less than the total age years."));
			return;
		}
			
		$balance_now_begin = $balance_tax_now;
		$balance_defer_begin = $balance_tax_defer;
		$balance_free_begin = $balance_tax_free;
		$current_living_withdraw = $withdraw_living;
		$income_tax = 0;
		for($age = $current_age; $age < $current_age + $total_years; ++$age){
			$current_living_withdraw *= 1 + $inflation / 100;
			$interest_year = $age - $current_age + $interest_year_start;
			$interest_percent = $this->interest_history[$interest_year];
			if($modified_interest_list && array_key_exists($interest_year, $modified_interest_list)){
				$interest = $modified_interest_list[$interest_year] / 100;
			}
			else{
				$interest = $interest_percent / 100;
			}
			$balance_now_end = $balance_now_begin;
			$balance_defer_end = $balance_defer_begin;
			$balance_free_end = $balance_free_begin;
			
			$total_withdraw = 0;
			if($age < $retirement_age){//can work
				//annual deposit
				//no withdraw
				$tax_now_gain = ($balance_now_begin + $deposit_tax_now) * $interest;
				$tax_defer_gain = ($balance_defer_begin + $deposit_tax_defer) * $interest;
				$tax_free_gain = ($balance_free_begin + $deposit_tax_free) * $interest;
			}
			else{//retire
				//no deposit
				$tax_now_gain = $balance_now_begin * $interest;
				$tax_defer_gain = $balance_defer_begin * $interest;
				$tax_free_gain = $balance_free_begin * $interest;
				$total_withdraw += $current_living_withdraw;
			}
			
			if($tax_now_gain >= 0){
				$invest_tax_amount = $tax_now_gain * ($tax_investment / 100);
				$tax_now_gain -= $invest_tax_amount;
			}
			else{
				$invest_tax_amount = 0;
			}

			if($age >= $ltc_age_start && $age < $ltc_age_start + $ltc_years){//LTC
				//LTC withdraw
				$total_withdraw += $withdraw_ltc;
			}
			
			/*if($age == 70 && $balance_defer_end > 0){
				$balance_defer_end = 0;
				$total_withdraw -= $balance_defer_end * (1 - $tax_income / 100);
				$income_tax = $balance_defer_end * ($tax_income / 100);
			}*/
			
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
						$before_tax_withdraw = ($total_withdraw - $balance_free_end - $balance_now_end) / (1 - $tax_income / 100);
						$income_tax = $before_tax_withdraw * ($tax_income / 100);
						$balance_defer_end -= $before_tax_withdraw;
						$balance_now_end = 0;
					}
					$balance_free_end = 0;
				}
			}
			
			$data[$interest_year] = array(
				$age, number_format($balance_now_begin + $balance_defer_begin + $balance_free_begin, 0),
				number_format($balance_now_begin, 0), number_format($balance_defer_begin, 0), number_format($balance_free_begin, 0), 
				$age < $retirement_age ? number_format($deposit_tax_now, 0) : 0, $age < $retirement_age ? number_format($deposit_tax_defer, 0) : 0, $age < $retirement_age ? number_format($deposit_tax_free, 0) : 0,
				$interest_percent.'%', 
				'<input type="number" class="modified-interest" style="width:55px" '.($modified_interest_list && array_key_exists($interest_year, $modified_interest_list) ? 'value="'.$modified_interest_list[$interest_year].'"' : '').'>%',
				number_format($invest_tax_amount, 0), number_format($income_tax, 0),	
				$age >= $retirement_age ? number_format($current_living_withdraw, 0) : 0, 
				$age >= $ltc_age_start && $age < $ltc_age_start + $ltc_years ? number_format($withdraw_ltc, 0) : 0,	
				number_format($balance_now_end, 0), number_format($balance_defer_end, 0), number_format($balance_free_end, 0), 
				number_format($balance_now_end + $balance_defer_end + $balance_free_end, 0)
			);
			$balance_now_begin = $balance_now_end;
			$balance_defer_begin = $balance_defer_end;
			$balance_free_begin = $balance_free_end;
		}
		echo json_encode(array('data' => $data, 'post' => $post));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */