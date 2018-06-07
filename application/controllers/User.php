<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		//$this->load->model('Ion_auth_model');
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language','form'));
		$this->data['uid'] =  $this->session->userdata('user_id');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index()
	{
		
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('login');
		}
		else if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
				
			$this->_render_page('admin/header', $this->data);
			$this->_render_page('admin/dashboard', $this->data);
			$this->_render_page('admin/footer', $this->data);
		}
		else if($this->ion_auth->logged_in())
		{	

			$this->_render_page('admin/header', $this->data);
			$this->_render_page('admin/dashboard', $this->data);
			$this->_render_page('admin/footer', $this->data);
		}

	}

		public function list_user()
	{
		
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			$this->_render_page('admin/header', $this->data);
			$this->_render_page('admin/user_list', $this->data);
			$this->_render_page('admin/footer', $this->data);
		

	}

	public function login(){
		if($this->ion_auth->logged_in()){
			redirect('/');
		}
		$this->data['title'] = $this->lang->line('login_heading');

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('login'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('user/login', $this->data);
		}
	
		
	}

	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		// if ($returnhtml)
		// {
			return $view_html;
		// }
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('login');
	}

	/*public function get_plan(){
		    $plan = $this->input->post('plan');
			$plan_query = $this->db->get_where('plans',array('plan' => $plan));
			$plan_result = $plan_query->row();
			$plan_id = $plan_result->id;
			return $plan_id;
	}*/

	public function register($User_link=""){
		$this->data['title'] = $this->lang->line('create_user_heading');
		$query = $this->db->get("plans");
		$result = $query->result_array();
		$planArray = array('0' => 'Select Plan');
		foreach ($result as $row){
			
			$planArray[] = $row['plan'];

		}

		$this->data['planOptions'] = $planArray;

		/*if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('register', 'refresh');
		}*/
		$this->data['identity'] = array(
				'name' => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Email',
				'id' => 'identity',
				'type' => 'text',
				'required' => 'required',
				
			);	

			$this->data['user_name'] = array(
				'name' => 'user_name',
				'class' => 'form-control',
				'placeholder' => 'Username',
				'id' => 'user_name',
				'type' => 'text',
				'required' => 'required',
				
			);
			$this->data['country'] = array(
				'name' => 'country',
				'class' => 'form-control',
				'placeholder' => 'country',
				'id' => 'country',			
			);
			$this->data['plan'] = array(
				'name' => 'plan',
				'class' => 'form-control',
				'placeholder' => 'plan',
				'id' => 'plan',			
					);

			$this->data['phone'] = array(
				'name' => 'phone',
				'class' => 'form-control',
				'placeholder' => 'Whatsapp',
				'id' => 'phone',
				'type' => 'text',
				'required' => 'required',
				
			);

			$this->data['skype'] = array(
				'name' => 'skype',
				'class' => 'form-control',
				'placeholder' => 'Skype',
				'id' => 'skype',
				'type' => 'text',
				
			);
			
			$this->data['password'] = array(
				'name' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Password',
				'id' => 'password',
				'type' => 'password',
				'required' => 'required',
				
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'class' => 'form-control',
				'placeholder' => 'Confirm Password',
				'id' => 'password_confirm',
				'type' => 'password',
				
			);
			$this->data['aflink'] = array(
				'name' => 'aflink',
				'class' => 'form-control',
				'placeholder' => 'Affiliate Link',
				'id' => 'aflink',
				'type' => 'text',
				'required' => 'required',
				'value' => $User_link,
				
			); 
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		$this->form_validation->set_rules('user_name', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
		
		$this->form_validation->set_rules('identity', 'Please enter a valid email.', 'trim|required|valid_email');
		$this->form_validation->set_rules('identity',' ','callback_is_unique_email');
				
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('skype', 'Skype', 'trim|valid_email');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required');
		$this->form_validation->set_rules('aflink', 'Affiliate Link', 'trim|required|callback_link_check');
		if ($this->form_validation->run() === TRUE)
		{
			//print_r($_POST); die;
			$email = strtolower($this->input->post('identity'));
			$identity = $this->input->post('user_name');
			$password = $this->input->post('password');
			/*$plan = $this->input->post('plan');
			$plan_query = $this->db->get_where('plans',array('plan' => $plan));
			$plan_result = $plan_query->row();
			//$plan_id = $plan_result->id;
			$pln_id = $plan_result->id;*/

			$aflink = $this->input->post('aflink');
			$parent_query = $this->db->get_where('users',array('aflink' => $aflink));
			//echo $this->db->last_query();
			$parent_result = $parent_query->row();
			$link_id = $parent_result->id;
			$usercounterResult = $this->db->get_where('users',array('parent_id' => $link_id));
			$user_counter = count($usercounterResult->result()) + 1;
			//echo $user_counter; die;

			function generateRandomString($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
			}

			$rstr =  generateRandomString(); 
			$uname = $_POST['user_name'];
			$link = $uname."_".$rstr; 

			$additional_data = array(
				'first_name' => 'XXXXXXXXX',
				'last_name' => 'XXXXXXXXX',
				'company' => 'XXXXXXXXX',
				'phone' => $this->input->post('phone'),
				'skype' => $this->input->post('skype'),
				'country' => $this->input->post('country'),
				'plan' => $this->input->post('plan'),
				'aflink' => $link,
				'parent_id' => $link_id,
				'user_counter' => $user_counter,
			);
		}
		
		if ($this->form_validation->run() === TRUE)
		{	//print_r($additional_data); die;
			$this->ion_auth->register($identity, $password, $email, $additional_data);	
			$this->session->set_flashdata('message', 'Account created successfully!!');
			//$this->session->set_flashdata('success', 'Your Affiliation Link is: '.$aflink);

			// check to see if we are creating the user
			// redirect them back to the admin page
			$message = "Hello ".$identity." ,"."<br/>"."You have registered successfully.We will get back to you soon once your payment is confirmed."."<br/>"."Thanks.";
			
			$this->email->from('hello@dbiz8.com', 'Your Name');
			$this->email->to($email);
			$this->email->subject('Registeration Mail');
			$this->email->message($message);

			$this->email->send();
			if($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
				redirect("list_user");
			}else{
				redirect("register");
			}
			
			
		}else
		{	
			// display the create user form
			// set the flash data error message if there is one
			
			if(isset($_POST) && !empty($_POST)){
		
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			

			$this->data['identity'] = array(
				'name' => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Email',
				'id' => 'identity',
				'type' => 'text',
				'required' => 'required',
				'value' => $this->form_validation->set_value('identity'),
			);	

			$this->data['user_name'] = array(
				'name' => 'user_name',
				'class' => 'form-control',
				'placeholder' => 'Username',
				'id' => 'user_name',
				'type' => 'text',
				'required' => 'required',
				'value' => $this->form_validation->set_value('user_name'),
			);

			$this->data['phone'] = array(
				'name' => 'phone',
				'class' => 'form-control',
				'placeholder' => 'Whatsapp',
				'id' => 'phone',
				'type' => 'text',
				'required' => 'required',
				'value' => $this->form_validation->set_value('phone'),
			);

			$this->data['skype'] = array(
				'name' => 'skype',
				'class' => 'form-control',
				'placeholder' => 'Skype',
				'id' => 'skype',
				'type' => 'text',
				'value' => $this->form_validation->set_value('skype'),
			);
			
			$this->data['password'] = array(
				'name' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'class' => 'form-control',
				'placeholder' => 'Confirm Password',
				'id' => 'password_confirm',
				'type' => 'password',
				'required' => 'required',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			$this->data['aflink'] = array(
				'name' => 'aflink',
				'class' => 'form-control',
				'placeholder' => 'Affiliate Link',
				'id' => 'aflink',
				'type' => 'text',
				'required' => 'required',
				'value' => $this->form_validation->set_value('aflink'),
			); 
			$this->data['country'] = array(
				'name' => 'country',
				'class' => 'form-control',
				'id' => 'country',
				'type' => 'select',
				'value' => $this->form_validation->set_value('country'),
			); 
			$this->data['plan'] = array(
				'name' => 'plan',
				'class' => 'form-control',
				'id' => 'plan',
				'type' => 'select',
				'value' => $this->form_validation->set_value('plan'),
			); 
		}
			if($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
			$this->_render_page('admin/header', $this->data);
			$this->_render_page('admin/add_user', $this->data);
			$this->_render_page('admin/footer', $this->data);
			}else{

				$this->_render_page('user/register', $this->data);

			}
			
		
	}

	}

	public function link_check(){

		$link1 = $this->input->post('aflink');
		$query1 =  $this->db->get_where('users',array('aflink' => $link1));
		$result1 = $query1->row();
		if(empty($result1))
		{
			$this->form_validation->set_message('link_check', 'Please enter a valid affiliate link.');
            return FALSE;
		}
		else
		{
			return TRUE;
		}
		

	}

		public function is_unique_email(){
		$identity = $this->input->post('identity');
		$queryIdentity =  $this->db->get_where('users',array('email' => $identity));
		$resultIdentity = $queryIdentity->row();
		if(!empty($resultIdentity))
		{
			$this->form_validation->set_message('is_unique_email', 'The email address already exists.');
            return FALSE;
		}
		else
		{
			return TRUE;
		}
		

	}
		public	function buildTree(array $elements, $parentId ) {
    $branch = array();

    foreach ($elements as $key => $element) {
        if ($element['parent_id'] == $parentId) { 
            $branch[] = $element;
        }
    }

    return $branch;
}
public function binary(){
		if($this->ion_auth->logged_in()){
			//$this->_render_page('admin/header');
			$this->_render_page('admin/tree');
			//$this->_render_page('admin/footer');
}
}
/*public function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if ($array['children'][$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
            //$results = $subarray;
        }
    }

    return $results;
}*/

 public function array_flatten($array) { 
  if (!is_array($array)) { 
    return false; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, $value); 
    } else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
}

public function childrenArray($pid)
{
$coutQuery = $this->db->get_where('users',array('parent_id' => $pid));
$childResultArray = $coutQuery->result_array();

return $childResultArray;
}



public function tree(){

$SQL1 = "SELECT distinct parent_id FROM users";
$queryd = $this->db->query($SQL1);
$resultARR = $queryd->result_array(); 
$SQL = "SELECT child.id, child.username,  child.parent_id,  parent.username as ParentName FROM users child JOIN users parent ON child.parent_id = parent.id ";
$query = $this->db->query($SQL);
$result = $query->result_array();
	
$resultARR1 =array();
foreach ($resultARR as $key => $value) {
	$resultARR[$key]['children'] = User::buildTree($result,$resultARR[$key]['parent_id']);  
	$resultARR1[] = $resultARR[$key]['children'];
		
}

$vall = User::array_flatten($resultARR1);

echo "<pre>";
//print_r(User::getChildList());
$uid = $this->session->userdata('user_id');
$this->data['childrenArray'] =  json_encode(User::get_user_children());
if($this->ion_auth->logged_in()){
			//$this->_render_page('admin/header');
			$this->_render_page('admin/tree',$this->data);
			//$this->_render_page('admin/footer');
}
//$parenmtId =  $this->session->userdata('user_id');


//print_r(User::search($resultARR, 'parent_id', '1')) ;


 
		// $usersQuery = $this->db->get_where('users',array('parent_id' => $uid));
		// //echo $this->db->last_query(); die;
		// $usersResultArray = $usersQuery->result_array();
		// print_r($usersResultArray); die;
		
		// $this->load->view('admin/tree');
		

	}

public function getChildList($cid = false)

{	$uid = $this->session->userdata('user_id');
	
	if($cid){
		$uid = $cid;
	}
	$getChildArray = User::childrenArray($uid );
	$childArrayList = array();

	foreach($getChildArray as $childKey => $childvalue){
	//$resultArr = User::fact($childvalue['id']);
	$childArrayList[] = $childvalue;


	}


return $childArrayList;
}

public function get_user_children($user_id = false)
{ // print_r($level);
 //print_r($user_id);die; 
 if($user_id or $user_id==0) { 
 	$children = array();
 	$users = $this->getChildList($user_id);
 	if($users)
 	{ 
 
 	foreach($users as $k => $v)
 	{ 			
  			//$children[$k]['id'] = $v['id'];
  			$children[$k]['name'] = $v['username'];
  			$children[$k]['title'] = 'affiliate';
   			$children[$k]['children'] = $this->get_user_children($v['id']); 
 		 
   } 

 } 
return $children;
 }
else 
{ 
return false;
 } 
}
		/*public function check_Linkbinary(){

		$link1 = $this->input->post('aflink');
		$cntquery = $this->db->get_where('users',array('aflink' => $link1));
		$cntresult = $cntquery->result_array();
		if(count($cntresult) >= '2')
		{
			$this->form_validation->set_message('check_Linkbinary', 'Can not use this affiliate link!!');
            return FALSE;
		}
		else
		{
			return TRUE;
		}
		

	}*/
	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('user/forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("forgot_password");
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				$data = array(
                        'identity'=>$forgotten['identity'],
                        'forgotten_password_code' => $forgotten['forgotten_password_code'],
                    );
                    $this->email->set_mailtype("html");
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n");
                    $this->email->from('hello@dbiz8.com');
                    $this->email->to($this->input->post('identity'));
                    $this->email->subject("forgot password");
                    $body = $this->load->view('auth/email/forgot_password.tpl.php',$data,TRUE);
                    $this->email->message($body);

                    if ($this->email->send()) {
                    	$this->session->set_flashdata('message','Email has been sent on your email Address. Please check your email to reset password.'); 
                        redirect('login');
                    } 
                    else {
                        echo "Email not send .....";
                        show_error($this->email->print_debugger());
                    }
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("forgot_password");
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				);
				$this->data['user_id'] = array(
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('user/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("login");
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('reset_password/' . $code);
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("forgot_password");
		}
	}


	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			
			redirect('user');
		}
	
		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		$this->form_validation->set_rules('plan', $this->lang->line('edit_user_validation_plan_label'), 'trim');
	//	$this->form_validation->set_rules('country', $this->lang->line('edit_user_validation_country_label'), 'trim');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{ 
				//$pln_id = get_plan();
			$plan = $this->input->post('plan');
			$plan_query = $this->db->get_where('plans',array('plan' => $plan));
			$plan_result = $plan_query->row();
			//$plan_id = $plan_result->id;
			$pln_id = $plan_result->id;
				$data = array(		
					'username' => $this->input->post('username'),
					'phone' => $this->input->post('phone'),
					//'country' => $this->input->post('country'),
					'plan' => $pln_id,
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					// Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData))
					{

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					if($this->ion_auth->is_admin()){
						redirect('list_user','refresh',$this->data);
					}else{
						
						$this->session->set_flashdata('success', 'Pack upgraded successfully.');
						redirect('edit_user/' .$id,'refresh',$this->data);
					}
					

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					$this->redirectUser('edit_user/'.$id ,'refresh');

				}

			}
		}
				// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['username'] = array(
			'name'  => 'username',
			'id'    => 'username',
			'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('username', $user->username),
		);
		/*$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);*/
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'class' => 'form-control',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['plan'] = array(
			'name'  => 'plan',
			'id'    => 'plan',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('plan', $user->plan),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'form-control',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'form-control',
			'type' => 'password'
		);
		$result = $this->db->get('plans');
		$this->data['plans'] = $result->result();

		$this->_render_page('admin/header');
		$this->_render_page('user/edit_user', $this->data);
		$this->_render_page('admin/footer');
	}


	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */

	public function calculate($id,$p_id,$pop)
	{	
			$query = $this->db->get_where('users',array('id' => $id,'active' => '1'));
			$totalCount = $this->db->get_where('users',array('parent_id' => $p_id, 'active' => '1')); 
			$total  = count($totalCount->result());

			$resultArrayChild = $query->row();	
			/********* get plan *******************/	
			$currentPlan = $resultArrayChild->plan;	

			/*********calculate activation days***************/
			$getimestamp = $this->db->get_where('users',array('id' => $p_id, 'active' => '1')); 
			$timestamp = $getimestamp->row();
			$activated_on = $timestamp->activated_on;
			//echo $activated_on; 
			$activated_date = date('m-d-y',$activated_on);
			$current_date = date('m-d-y');
			$calculate_days = date_diff($activated_date,$current_date);

				if(!empty($currentPlan))
				{
					$planDeetailArrayObj = $this->db->get_where('plans', array('id' => $currentPlan));
					$detailArray = $planDeetailArrayObj->row();
					if($total == 2 && $calculate_days <= 7 )
					{
						/*******compare plan values*******************/	
							$currentChildPlans = $totalCount->result();	
							//echo "<pre>";
						
							$plans =array();
							foreach ($currentChildPlans as $currentChildPlan) {
								//print_r($currentChildPlan);
								$plans[] = $currentChildPlan->plan;
							}
							
							$royaltie = array();
							foreach($plans as $key => $value){
								$planRoyaltieArrayObj = $this->db->get_where('plans', array('id' => $value));
								
					            $planRoyaltieArray = $planRoyaltieArrayObj->row();
					           // print_r($planRoyaltieArray);	
					            $plan_royaltie[] = 	$planRoyaltieArray->royaltie;				

							}
							/*print_r($royaltie);
							min($royaltie);*/
							
					  $fast_bonus = min($plan_royaltie) * 15/100 ;					 
					  $arrayTostore = array(
					  	'user_id' => $p_id,
					  	'fast_bonus' => $fast_bonus,
					   ); 
					  
					 $queryforparent = $this->db->insert('bonus',$arrayTostore);
					}

				 if($total <= 2 )
					{
					  $bonus_estagio = ($detailArray->royaltie) * ($detailArray->bonus_estagio ) / 100; /*BE 18% parent*/
					  $bonus_indirect =  ($detailArray->royaltie) * ( $detailArray->bonus_indirect ) / 100; /*BT parent of parent*/ 
					  $arrayTostore = array(
					  	'user_id' => $p_id,
					  	'bonus_estagio' => $bonus_estagio,
					   ); 
					  $arrayTostoreForPOP = array(
					  	'user_id' => $pop,
					  	'bonus_indirect' => $bonus_indirect,
					   );
					 $queryforparent = $this->db->insert('bonus',$arrayTostore);
					 $queryforpop = $this->db->insert('bonus',$arrayTostoreForPOP); 
					}
					else
					{
					 $bonus_direct =  ($detailArray->royaltie) * ( $detailArray->bonus_direct ) / 100;  /*BPM parent of parent*/  
					  $arrayTostore = array(
					  	'user_id' => $p_id,
					  	'bonus_direct' => $bonus_direct,
					   );  
					 $queryforparent = $this->db->insert('bonus',$arrayTostore);  
					}  
				}
			/**************************/	


	}

	public function equilance_bonus($pid,$pop)
	{ 
		$parentQuery = $this->db->get_where('users',array('id' => $pid, 'active' => '1'));
		$parentResultArray = $parentQuery->row();
		$parentPlan = $parentResultArray->plan;
		$equivalence_bonus = $parentResultArray->equivalence_bonus;
		$getusrCounter = $parentResultArray->user_counter;
		$chekActive = $parentResultArray->active;

		$popQuery = $this->db->get_where('users',array('id' => $pop, 'active' => '1'));
		$popResultArray = $popQuery->row();
		$popPlan = $popResultArray->plan;

		$totalCount = $this->db->get_where('users',array('parent_id' => $pid, 'active' => '1')); 
		$poptotalCount = $this->db->get_where('users',array('parent_id' => $pop, 'active' => '1')); 
		$total  = count($totalCount->result());
		$poptotal  = count($poptotalCount->result());
		$this->db->update('users',array('child_count' => $total),array('id' => $pid));
		//echo $total; echo "-----".$poptotal;
		$this->db->update('users',array('grand_child_count' => $poptotal),array('id' => $pop));

		/******************check sale CNI and calculate bonus****************/
		if($popPlan == 'medium')
		{
			if(($getusrCounter == '1' && $chekActive == '1') || ($getusrCounter == '3' && $chekActive == '1') )
			{
				if($total == '10')
				{
					$this->db->insert('bonus',array('equivalence_bonus' => $equivalence_bonus),array('user_id' => $pid));
				}

			}

		}

	}

	public function activate($id, $code = FALSE)
	{	 
		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{	
			$p = $this->db->get_where('users',array('id' => $id));
			$presult = $p->row();
			$pid = $presult->parent_id;

			$pop = $this->db->get_where('users',array('id' => $pid));
			$popresult = $pop->row();
			$popid = $popresult->parent_id;

			$activation = $this->ion_auth->activate($id);
			$this->db->update('users',array(
											'activated_on' => time(),
											),
									  array('id' => $id
									  		)
											);
			User::calculate($id ,$pid,$popid);
			User::equilance_bonus($pid,$popid);

			$query = $this->db->get_where('users',array('id' => $id));
			$result = $query->row();
			$uemail = $result->email;
			$uname = $result->username;
			$ulink = $result->aflink;
			$data = array(
                        'identity'=>$uname,
                        'activation' => $activation,
                    );		
			$this->email->set_mailtype("html");
			$this->email->from('hello@dbiz8.com', 'Dbiz8');
			$this->email->to($uemail);
			$this->email->subject('Confirmation-Email');
			$body = $this->load->view('auth/email/activate.tpl.php',$data,TRUE);
			$this->email->message($body);
			$this->email->send();
		}

		if ($activation)
		{
			
			// redirect them to the auth page
			$this->session->set_flashdata('message', 'Status Activated');
			redirect('list_user', 'refresh');
		}
		else
		{
			
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			//redirect('forgot_password', 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('user/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					return show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('list_user', 'refresh');
		}
	}

	public function addPlan()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin()) 
		{
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$this->form_validation->set_rules('plan', 'Plan Name', 'trim|required|is_unique[plans.plan]');
			$this->form_validation->set_rules('points','points','trim|required|numeric');
			$this->form_validation->set_rules('aquisition','aquisition','trim|required|numeric');
			$this->form_validation->set_rules('royaltie','royaltie','trim|required|numeric');
			$this->form_validation->set_rules('bonus_estagio','bonus_estagio','trim|required|numeric');
			$this->form_validation->set_rules('fast_bonus','fast_bonus','trim|required|numeric');
			$this->form_validation->set_rules('bonus_direct','bonus_direct','trim|required|numeric');
			$this->form_validation->set_rules('bonus_indirect','bonus_indirect','trim|required|numeric');
			$this->form_validation->set_rules('assistant_bonus','assistant_bonus','trim|required|numeric');
			$this->form_validation->set_rules('guests','guests','trim|required');
			$this->form_validation->set_rules('equivalence_bonus','equivalence_bonus','trim|required|numeric');
			if ($this->form_validation->run() === TRUE)
			{
				//$plan = $this->input->post('plan');
				$row = array(
							
							'plan'=> $this->input->post('plan'),
							'aquisition'=> $this->input->post('aquisition'),
							'points'=> $this->input->post('points'), 
							'royaltie'=> $this->input->post('royaltie'), 
							'bonus_estagio'=> $this->input->post('bonus_estagio'),
							'fast_bonus'=> $this->input->post('fast_bonus'),
							'bonus_direct'=> $this->input->post('bonus_direct'),
							'bonus_indirect'=> $this->input->post('bonus_indirect'),
							'assistant_bonus'=> $this->input->post('assistant_bonus'),
							'guests'=> $this->input->post('guests'),
							'equivalence_bonus'=> $this->input->post('equivalence_bonus'),
						); 
				$query = $this->db->insert('plans',$row);
				//$id = $this->db->insert_id(); 
                //echo $id; 
				if($query)
				{
					$this->session->set_flashdata("success","Plan added successfully");
					redirect("user/allPlan");
				}
			}else{

			}
				$this->load->view('admin/header');
				$this->load->view('admin/create_plan');
				$this->load->view('admin/footer');
			
		}
	}

	public function viewAflink()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}
		else
		{	$email = $this->session->userdata('email');
			$query = $this->db->get_where('users', array('email' => $email));
			$result = $query->row();
			if($query)
			{
				$this->data['alink'] = $result->aflink;
			}
			$this->load->view('admin/header');
			$this->load->view('admin/view_aflink',$this->data);
			$this->load->view('admin/footer');
			
		}
	}

	public function bonus()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}
		else
		{	
			
			$data = $this->session->userdata('user_id');
			$getbonusResult = $this->db->get_where('bonus',array('user_id' => $data ));
			$getBonus = $getbonusResult->result();
			/*echo "<pre>";
			print_r($getBonus); die;*/
			$bonus_estagio = 0 ;
			$bonus_direct =  0 ;
			$bonus_indirect =  0 ;
			$fast_bonus = 0;
			foreach ($getBonus as $key => $getBonusItem)
			 {
			$bonus_estagio += $getBonusItem->bonus_estagio;
			$bonus_direct += $getBonusItem->bonus_direct;
			$bonus_indirect += $getBonusItem->bonus_indirect;
			$fast_bonus += $getBonusItem->fast_bonus;
			$assistent_bonus += $getBonusItem->assistent_bonus;
			$equivalence_bonus += $getBonusItem->equivalence_bonus;
			 }

		}
		$this->data['bonus_estagio'] = $bonus_estagio; 
		$this->data['bonus_direct'] = $bonus_direct; 
		$this->data['bonus_indirect'] = $bonus_indirect; 
		$this->data['fast_bonus'] = $fast_bonus; 
		$this->data['assistent_bonus'] = $assistent_bonus;
		$this->data['equivalence_bonus'] = $equivalence_bonus;
		$this->load->view('admin/header');
		$this->load->view('admin/view_bonus',$this->data);
		$this->load->view('admin/footer');
		
	}

	public function allPlan()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}
		else if (!$this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$query = $this->db->get('plans');
			$this->data = $query->result();

			$this->load->view('admin/header');
			$this->load->view('admin/plan_data', array('data' => $this->data ));
			$this->load->view('admin/footer');
		}
	}

	public function editPlan($id)
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}else
		{
			$id = $this->uri->segment(3);  
			if(!empty($_POST)){

				$this->form_validation->set_rules('plan','plan','trim|required');
				$this->form_validation->set_rules('points','points','trim|required');
				$this->form_validation->set_rules('aquisition','aquisition','trim|required|numeric');
			    $this->form_validation->set_rules('royaltie','royaltie','trim|required|numeric');
			    $this->form_validation->set_rules('bonus_estagio','bonus_estagio','trim|required|numeric');
				$this->form_validation->set_rules('fast_bonus','fast_bonus','trim|required|numeric');
				$this->form_validation->set_rules('bonus_direct','bonus_direct','trim|required|numeric');
				$this->form_validation->set_rules('bonus_indirect','bonus_indirect','trim|required|numeric');
				$this->form_validation->set_rules('assistant_bonus','assistant_bonus','trim|required|numeric');
				$this->form_validation->set_rules('guests','guests','trim|required');
			    $this->form_validation->set_rules('equivalence_bonus','equivalence_bonus','trim|required|numeric');

				if ($this->form_validation->run() === TRUE)
				{
					$plan = $this->input->post('plan');
					$aqui = $this->input->post('aquisition');
					$royltie = $this->input->post('royaltie');
					$points = $this->input->post('points');
					$bonus_estagio = $this->input->post('bonus_estagio');
					$fast_bonus = $this->input->post('fast_bonus');
					$bonus_direct = $this->input->post('bonus_direct');
					$bonus_indirect = $this->input->post('bonus_indirect');
					$assistant_bonus = $this->input->post('assistant_bonus');
					$guests = $this->input->post('guests');
					$equivalence_bonus = $this->input->post('equivalence_bonus');

					$uid = $this->input->post('id');
					$result = $this->db->update('plans', array('plan' => $plan,'aquisition' => $aqui,'points' => $points,'royaltie' => $royltie ,'bonus_estagio' => $bonus_estagio ,'bonus_direct' => $bonus_direct ,'bonus_indirect' => $bonus_indirect,'assistant_bonus' => $assistant_bonus,'guests' => $guests,'equivalence_bonus' => $equivalence_bonus), array('id' => $uid));

					if($result)
					{ 
						$this->session->set_flashdata('success', 'Plan updated successfully!!');
						redirect('user/allPlan','refresh');
					} 
				}
				else
				{
					$this->data = $this->input->post();
					$this->load->view('admin/header');
					$this->load->view('admin/edit_plan', array('data' => $this->data));
					$this->load->view('admin/footer'); 
				} 
			}
			else
			{

				$this->db->where('id',$id);
				$query = $this->db->get('plans');
				$this->data = $query->row();
				$this->load->view('admin/header');
				$this->load->view('admin/edit_plan', array('data' => $this->data));
				$this->load->view('admin/footer');
			}
			}
		}

	public function deletePlan()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}else
		{
			$id = $this->uri->segment(3);
			$query = $this->db->delete('plans',array('id' => $id));
		}
		if($query)
		{
			$this->session->set_flashdata('success','Plan deleted successfully!!');
			redirect('user/allPlan','refresh');
		}
	}



	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */

	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')){
			return TRUE;
		}
			return FALSE;
	}
	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser(){
		if ($this->ion_auth->is_admin()){
			redirect('user');
		}
		if (!$this->ion_auth->is_admin()){
			redirect('user');
		}
		redirect('/', 'refresh');
	}

	
}
