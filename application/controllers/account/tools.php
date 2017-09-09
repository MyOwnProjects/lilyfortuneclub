<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Tools extends Account_base_controller {
	private $interest_history = array(
			1999 => 17.85, 2000 => -10.01, 2001 => -13.07, 2002 => -19.89, 
			2003 => 23.29, 2004 => 4.63, 2005 => 8.7, 2006 => 11.12, 2007 => -3.48, 2008 =>-38.9,
		2009 => 34.64, 2010 => 13.84, 2011 => -0.32, 2012 => 14.22, 2013 => 25.54, 2014 => 7.81, 2015 => -5.64
	);

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load_view('tools', array('interest_history' => $this->interest_history));
	}
	
	public function illustration_report(){
		$ret = array();
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

		$balance_now_begin = $balance_tax_now;
		$balance_defer_begin = $balance_tax_defer;
		$balance_free_begin = $balance_tax_free;
		$current_living_withdraw = $withdraw_living;
		$income_tax = 0;
		for($age = $current_age; $age < $current_age + $total_years; ++$age){
			$current_living_withdraw *= 1 + $inflation / 100;
			$interest_percent = $this->interest_history[$age - $current_age + $interest_year_start];
			$interest = $interest_percent / 100;
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
			
			array_push($ret, array(
				$age, number_format($balance_now_begin + $balance_defer_begin + $balance_free_begin, 0),
				number_format($balance_now_begin, 0), number_format($balance_defer_begin, 0), number_format($balance_free_begin, 0), 
				$age < $retirement_age ? number_format($deposit_tax_now, 0) : 0, $age < $retirement_age ? number_format($deposit_tax_defer, 0) : 0, $age < $retirement_age ? number_format($deposit_tax_free, 0) : 0,
				$interest_percent.'%', 
				number_format($invest_tax_amount, 0), number_format($income_tax, 0),	
				$age >= $retirement_age ? number_format($current_living_withdraw, 0) : 0, 
				$age >= $ltc_age_start && $age < $ltc_age_start + $ltc_years ? number_format($withdraw_ltc, 0) : 0,	
				number_format($balance_now_end, 0), number_format($balance_defer_end, 0), number_format($balance_free_end, 0), 
				number_format($balance_now_end + $balance_defer_end + $balance_free_end, 0)
			));
			$balance_now_begin = $balance_now_end;
			$balance_defer_begin = $balance_defer_end;
			$balance_free_begin = $balance_free_end;
		}
		echo json_encode($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */