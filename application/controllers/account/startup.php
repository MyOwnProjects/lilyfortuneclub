<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Startup extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$steps = array(array(
			'title' => 'Who',
			'comment' => '',
			'subject' => "Who we are?",
			'steps' => array(
				'<p>We are an independant team, based in San Francisco bay area, of <u>World Financial Group</u>. Our team leader (SMD), <b>Lily Min Zhu</b>, is top 25 of 70,000 agents in entire WFG, has made more than $350,000/year after two-year part time and one-year full time in this business. She had earned very good credibility from the customers, and recognitions from teammates and business partners. She is helping us to bulid success in personal career for everyone in this team.</p>
				<p><img src="'.base_url().'src/img/WFG_logo.jpg" class="pull-left" style="width:50px;margin-right:20px">World Financial Group, Inc. (WFG) is a financial services marketing company based in Johns Creek, Georgia, whose associates help people of all income levels create appropriate financial strategies, build financial confidence and pursue financial independence. WFG has thousands of associates in the Canada and U.S. dedicated to helping everyday people achieve their family&#39;s goals for their financial future, and more than 32,000 client accounts. WFG has selling agreements with more than 50 separate insurance and mutual funds companies. In June 2001, WFG was acquired by Aegon, and wholly owned by Transamerica, a subsidiary of AEGON.</p>
				<p><img src="'.base_url().'src/img/Transamerica_Corporation.png" class="pull-left" style="width:150px;margin-right:20px">The Transamerica Corporation is an American holding company for various life insurance companies and investment firms doing business primarily in the United States, offering life and supplemental health insurance, investments, and retirement services. In 1999, it became a subsidiary of Aegon.</p>
				<p><img src="'.base_url().'src/img/AEGON_(logo).svg" class="pull-left" style="width:100px;margin-right:20px">Aegon N.V. is a multinational life insurance, pensions and asset management company headquartered in The Hague, Netherlands, is one of the world&#39;s leading insurance, pension and related financial services organizations. At the end of 2015, Aegon companies employed approximately 31,530 people worldwide, serving millions of customers. Aegon has major operations in the United States, where it is mostly represented through World Financial Group and Transamerica.</p>',
			)
		),
		array(
				'title' => 'What',
				'subject' => "What we do?",
				'steps' => array(
					'<p>Unlike other companies who target only wealthy clients, WFG is dedicated to teaching people simple financial concepts that will help them put their money to work more effectively and move them toward achieving their financial goals.</p>
					<p>We also helps families by offering everyday people an uncommon opportunity - the chance to change careers and be in business <b>for themselves, but not by themselves</b>.</p>
					<p>We are helping individuals and families who are often overlooked by other companies in the financial services industry.</p> 
					<p>We are working with clients to create a customized strategy to protect them and their families. </p>
					<p>We are educating individuals, families and business owners that financial decisions made today are critical in determining their financial futures.</p>'
				),
			),
			array(
				'title' => 'How',
				'comment' =>'You can only apply for the license after you finished both of the 52 hours courses and license exam.',
				'subject' => "How we do?",
				'image_file_name'=> 'license-application',
				'steps' => array(
					"<p>To start up the business, the first step is to invite people. You can either invite your friends, relatives or colleagues to BPM, or one to one in coffee shop, office and your home. Bring your guest in front of your lead, and your lead will help you to recruit.</p>
					<p>A good way is to invite your friends to your home for kids' birthday party, or home gathering. Bring your lead to the party, and your lead will help you to invite them.</p>
					<p>Go to <a href=\"".base_url()."account/business\">Start your business</a> for details.</p>
					",
					),
				),
			array(
				'title' => 'Basic',
				'comment' =>'You can only apply for the license after you finished both of the 52 hours courses and license exam.',
				'subject' => "Basic business and finance concept",
				'image_file_name'=> 'license-application',
				'steps' => array(
					"<h5><b>WFG Levels</b></h5> 
					<p>There are 5 levels in a SMD team: Senior Marketing Direct (SMD), Senior Marketing (MD), Senior Associate (SA), Associate (A), Trainee Associate (TA). The initial level is Trainee Associate. After you become a WFG member, you fiest level is Trainee Associate.</p>
					&nbsp;
					<h5><b>Trainee and Trainer</b></h5>
					<p>
					When you bring your guest in front of your lead, you are in a field training. You lead is the trainer, and you are the trainee. Field training is the most efficient way to improve your business and professional skills. You can learn the skills of recruit, sales and objection handling.
					</p>
					&nbsp;
					<h5><b>Mutual Fund</b></h5>
					<p>
					A mutual fund is an investment vehicle made up of a pool of funds collected from many investors for the purpose of investing in securities such as stocks, bonds, money market instruments and similar assets. Mutual funds are operated by money managers, who invest the fund's capital and attempt to produce capital gains and income for the fund's investors.
					</p>
					<p>Mutual funds is considered Tax Now.</p>
					&nbsp;
					<h5><b>401K</b></h5>
					<p>
					By definition, a 401(k) plan is an arrangement that allows an employee to choose between taking compensation in cash or deferring a percentage of it to a 401(k) account under the plan. The amount deferred is usually not taxable to the employee until it is withdrawn or distributed from the plan.
					</p>
					&nbsp;
					<h5><b>IRA / Triditional IRA</b></h5>
					<p>
					An individual retirement account (IRA) is an investing tool used by individuals to earn and earmark funds for retirement savings. Someone can claim the amount as a deduction on his income tax return in IRA, and the Internal Revenue Service does not apply income tax to those earnings. However, when the individual withdraws from the account during retirement, his withdrawals are taxed as income.
					</p>
					<p>IRA and 401K are considered Tax Deferred</p>
					&nbsp;
					<h5><b>Roth IRA</b></h5>
					<p>
					Roth IRA contributions are not tax-deductible. However, eligible distributions are tax-free. This means, you contribute to a Roth IRA with after-tax dollars, but as the account grows, you do not face any taxes on capital gains, and when you retire, you can withdraw from the account without incurring any income taxes on your withdrawals.
					</p>
				",
				),
			),
		);
		$this->summary = array(
			'summary' => 'There are 2 or 3 steps to get your license, denpends on the state',
			'steps' => $steps		
		);
		
	}
	
	public function index(){
		$this->load_view('startup', array('summary' => $this->summary));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */