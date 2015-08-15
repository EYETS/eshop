<?php

class Login_model extends CI_Model {

    function validate() {
        $adminEmail = strtolower($this->input->post('adminEmail'));
        $adminPwd = md5($this->input->post('adminPwd'));

        $this->db->where('user_email', $adminEmail);
        $this->db->where('user_pwd', $adminPwd);
        $query = $this->db->get('dx_users');

        if ($query->num_rows == 1) {
            $row = $query->row();
            if ($row->user_banned == 1) {
                $this->messages->add("لقد تم حظرك، بسبب : ' " . $row->user_ban_reason . " '", "error");
                return false;
            }
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $q = $this->db->query("UPDATE `dx_users` SET  
						`user_last_login` =  CURRENT_TIMESTAMP,
						`user_last_ip` =  '$user_ip'
						 WHERE `user_email` = '$adminEmail'");

            $data = array(
                'admin_username' => $row->user_uname,
                'admin_full_name' => $row->user_full_name,
                'admin_uid' => $row->user_uid,
                'admin_group' => $row->group_uid,
                'admin_lastVisit' => $row->user_last_login,
                'admin_lastIp' => $row->user_last_ip,
                'is_logged_in' => true
            );
            $this->session->set_userdata($data);
            return true;
        } else {
            $session = $this->session->all_userdata();
            if (isset($session['error_login'])) {
                $data = array(
                    'error_login' => $session['error_login'] + 1
                );
            } else {
                $data = array(
                    'error_login' => 1
                );
            }
            $this->messages->add("البريد الإلكترونى أو كلمة المرور غير صحيحة.", "error");
            $this->session->set_userdata($data);
            return false;
        }
    }

    function validate_cap() {
        // First, delete old captchas
        $expiration = time() - 3600; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0) {
            $this->messages->add("رمز التحقق غير صحيح.", "error");
            return false;
        } else {

            $adminPwd = md5($this->input->post('adminPwd'));

            $adminEmail = strtolower($this->input->post('adminEmail'));

            $this->db->where('user_email', $adminEmail);
            $this->db->where('user_pwd', $adminPwd);
            $query = $this->db->get('dx_users');

            if ($query->num_rows == 1) {
                $row = $query->row();
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $q = $this->db->query("UPDATE `dx_users` SET  
							`user_last_login` =  CURRENT_TIMESTAMP,
							`user_last_ip` =  '$user_ip'
							 WHERE `user_email` = '$adminEmail'");

                $data = array(
                    'admin_username' => $row->user_uname,
                    'admin_uid' => $row->user_uid,
                    'admin_group' => $row->group_uid,
                    'admin_lastVisit' => $row->user_last_login,
                    'admin_lastIp' => $row->user_last_ip,
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                return true;
            } else {
                $session = $this->session->all_userdata();
                if (isset($session['error_login'])) {
                    $data = array(
                        'error_login' => $session['error_login'] + 1
                    );
                } else {
                    $data = array(
                        'error_login' => 1
                    );
                }
                $this->messages->add("البريد الإلكترونى أو كلمة المرور غير صحيحة.", "error");
                $this->session->set_userdata($data);
                return false;
            }
        }
    }

    function send_password() {

        $adminEmail = $this->input->post('mail');
        $confirm_code = rand(1, 999999);

        $q = $this->db->query("SELECT * FROM dx_users WHERE user_email = '$adminEmail'");
        if ($q->num_rows() > 0) {

            $data = array(
                'user_activation_code' => $confirm_code
            );


            $this->db->where('user_email', $adminEmail);
            $this->db->update('dx_users', $data);

            $session = $this->session->all_userdata();
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => $session['siteSMTPhost'],
                'smtp_port' => $session['siteSMTPport'],
                'smtp_user' => $session['siteSMTPuname'],
                'smtp_pass' => $session['siteSMTPpwd'],
                'mailtype' => 'html',
                'charset' => 'UTF-8'
            );
            $this->load->library('email', $config);

            $this->email->from($session['siteEmail'], $session['siteName']);
            $this->email->to($adminEmail);

            $this->email->subject('رابط أستعادة كلمة المرور لموقع ' . $session['siteName']);
            $url = site_url('login/reset_password');
            $message = $this->reset_password_message($confirm_code, $url);
            $this->email->message($message);

            $check = $this->email->send();

            $this->messages->add("لقد تم أرسال رابط أعادة تعيين كلمة المرور لبريدك الإلكترونى بنجاح", "success");
            redirect('login/reset_password');
        } else {
            $this->messages->add("البريد الإلكترونى أو أسم المستخدم غير مسجل لدينا برجاء التأكد والمحاولة مرة أخرى", "error");
            redirect('login');
        }
    }

    function reset_password() {

        $user_email = $this->input->post('user_email');
        $user_activation_code = $this->input->post('user_activation_code');
        $user_pwd = $this->input->post('user_pwd');
        $user_pwd = md5($user_pwd);

        $q = $this->db->get_where('dx_users', array('user_email' => $user_email, 'user_activation_code' => $user_activation_code));
        if ($q->num_rows() > 0) {
            $row = $q->row();

            $data = array(
                'user_pwd' => $user_pwd
            );


            $this->db->where('user_email', $row->user_email);
            $this->db->update('dx_users', $data);

            if ($this->db->affected_rows() > 0) {
                $this->messages->add("تم تغيير كلمة المرور بنجاح يمكنك تسجيل الدخول الأن", "success");
                redirect('login');
            } else {
                $this->messages->add("لقد حدث خطأ أثناء أعادة تعيين كلمة المرور.", "error");
                redirect('login/reset_password');
            }
        } else {
            $this->messages->add("البريد الإلكترونى أو أسم المستخدم غير مسجل لدينا برجاء التأكد والمحاولة مرة أخرى", "error");
            redirect('login/reset_password');
        }
    }

    function reset_password_message($confirm_code, $url) {

        return


                '
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Email Template - Meagan Fisher - CM2</title>

<style type="text/css">
strong{
	font-variant: small-caps;
	text-transform: lowercase;
	color:#949494;
}
</style>

</head>

<body marginheight="0" topmargin="0" marginwidth="0" leftmargin="0" style="margin: 0px; background-color: #FFFFFF; font-family: tahoma; text-align:right">
<!--100% body table-->
<table cellspacing="0" border="0" bgcolor="#ffffff" style="margin: 0; padding: 0; border: 0;" width="100%" cellpadding="0">
  <tr style="margin: 0; padding: 0; border: 0;">
    <td align="center" style="margin: 0; padding: 0; border: 0;">
    <!--email container-->
    	<table cellspacing="0" border="0" style="padding: 0; border: 0; margin: 0; background: url(images/bg.jpg);" bgcolor="#797979" width="805" cellpadding="0">
    		<tr height="76" style="margin: 0; padding: 0; border: 0;">
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/top-1.jpg);" width="102">
    			</td>
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/top-2.jpg);" width="601">
    				<table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0">
						<tr height="30" style="margin: 0; padding: 0; border: 0;">
							<td style="margin: 0; padding: 0; border: 0;" width="46"></td>
							<td style="margin: 0; padding: 0; border: 0;" width="508"></td>
							<td style="margin: 0; padding: 0; border: 0;" width="47"></td>
						</tr>
						
						<tr height="18" style="margin: 0; padding: 0; border: 0;"><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td></tr>
					</table>
    			</td>
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/top-3.jpg);" width="102">
    			</td>
    		</tr>
    		<tr height="67" style="margin: 0; padding: 0; border: 0;">
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td>
    			<td style="border: 0; padding: 0; color: #f9f9f9; margin: 0; background: #B9B9B9 url(images/header.jpg) no-repeat;" bgcolor="#B9B9B9" width="601"><div style="height:67px;">
    				<table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0" align="left">
    					<tr style="margin: 0; padding: 0; border: 0;">
    						<td style="margin: 0; padding: 0; border: 0;" width="452"><table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0">
    							<tr height="55" style="margin: 0; padding: 0; border: 0;">
    								<td style="margin: 0; padding: 0; border: 0;" width="30"></td>
    								<td style="margin: 0; padding: 0; border: 0;" align="left" width="422"><h1 style="padding: 13px 0 0 0; margin: 0; font-size: 20px; font-weight: bold; border: 0; color:#f9f9f9; font:Helvetica; font-family:tahoma; text-align:right">طلب أستعادة كلمة المرور</h1></td>
    								</tr>
    							<tr height="12" style="margin: 0; padding: 0; border: 0;">
    								<td style="margin: 0; padding: 0; border: 0;"></td>
    								<td style="margin: 0; padding: 0; border: 0;"></td>
    								</tr>
    							</table></td>
    						<td style="margin: 0; padding: 0; border: 0;" width="150"><table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0">
    							<tr><td><img src="http://expresswapp.net/assets/files/logos/3a591bb6bdd68365635cfebdd1cf6eb1.png" /></td></tr>
    							</table></td>
    						</tr>
    					</table>
    				</div></td>
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td>
    		</tr>
    		<tr style="padding: 0; font-size: 14px; line-height: 21px; font-family: Arial, sans-serif; border: 0; color: #8e8e8e; margin: 0;">
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td>
    			<td style="padding: 0; border: 0; margin: 0; background: #E4E4E4 url(images/bodybg.jpg);" bgcolor="#E4E4E4" width="601">
    			
    			<table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0" align="left">
					<tr height="20" style="margin: 0; padding: 0; border: 0;">
						<td style="margin: 0; padding: 0; border: 0;" width="32"></td>
						<td style="margin: 0; padding: 0; border: 0;"></td>
						<td style="margin: 0; padding: 0; border: 0;" width="32"></td>
					</tr>
					<tr style="margin: 0; padding: 0; border: 0;">
						<td style="margin: 0; padding: 0; border: 0;"></td>
						<td style="margin: 0; padding: 0; border: 0; color:#8E8E8E; font-family: Helvetica, Arial, sans-serif; font-size:14px; line-height:21px;" align="left">
							<table cellspacing="0" border="0" style="margin: 0; padding: 0; border: 0;" cellpadding="0" align="left">
								<tr style="margin: 0; padding: 0; border: 0;" height="50">
									<td style="margin: 0; padding: 0; border: 0;" width="576">
										<h2 style="font-size: 18px; font-weight: bold; border: 0; color: #767676; display: inline; padding: 0; margin: 0; font-family: tahoma; text-align:right; direction:rtl; float:right">عميلنا العزيز</h2>
									</td>
								</tr>
								<tr style="margin: 0; padding: 0; border: 0;">
									<td colspan="2" style="margin: 0; padding: 0; border: 0;">
										<p style="margin: 0; padding: 0; font-size: 12px; padding-bottom: 10px; font-family: tahoma; color:#949494; text-align:right; direction:rtl">كود أستعادة كلمة المرور هو : ' . $confirm_code . '</p>
                                        <p style="margin: 0; padding: 0; font-size: 12px; padding-bottom: 10px; font-family: tahoma; color:#949494; text-align:right; direction:rtl"> أستخدم هذا الرابط لأعادة تعيين كلمة المرور</p>
                                        <p style="margin: 0; padding: 0; font-size: 12px; padding-bottom: 10px; font-family: tahoma; color:#949494; text-align:right; direction:rtl"> <a href="' . $url . '">' . $url . '</a></p>
                                        
								  </td>
								</tr>
							</table>
						</td>
						<td style="margin: 0; padding: 0; border: 0;"></td>
					</tr>
					<tr height="25" style="margin: 0; padding: 0; border: 0;">
						<td style="margin: 0; padding: 0; border: 0;"></td>
						<td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td>
					</tr>
				
				<tr style="margin: 0; padding: 0; border: 0;">
					<td style="margin: 0; padding: 0; border: 0;" width="32"></td>
					<td style="padding: 20px 0 0; border: 0; margin: 0; background: url(images/storybg.jpg) no-repeat; color: #8E8E8E; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:21px;" align="left" width="601"><br />
				  </td>
					<td style="margin: 0; padding: 0; border: 0;" width="32"></td>
				</tr>
				<tr height="25" style="margin: 0; padding: 0; border: 0;"><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td></tr>
			</table>
    			
    			</td>
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td>
    		</tr>
    		<tr height="69" style="margin: 0; padding: 0; border: 0;">
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td> 
    			<td style="padding: 0; border: 0; margin: 0; background: #B9B9B9 url(images/footer.jpg);" bgcolor="#B9B9B9" width="601"><table cellspacing="0" border="0" style="padding: 0; border: 0; margin: 0;" cellpadding="0" width="601">
				<tr height="12" style="margin: 0; padding: 0; border: 0;"><td style="margin: 0; padding: 0; border: 0;" width="85"></td><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;" width="85"></td></tr>
				<tr height="40" style="margin: 0; padding: 0; border: 0;">
					<td style="margin: 0; padding: 0; border: 0;"></td>
					<td align="center" style="padding: 0; font-size: 12px; line-height: 22px; border: 0; color: #eeeeee; margin: 0; font-family:Helvetica,Arial,sans-serif">&nbsp;</td>
					<td style="margin: 0; padding: 0; border: 0;"></td>
				</tr>
				<tr height="12" style="margin: 0; padding: 0; border: 0;"><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td><td style="margin: 0; padding: 0; border: 0;"></td></tr>
			</table>
    			</td>
    			<td style="margin: 0; padding: 0; border: 0;">
    			</td>
    		</tr>
    		<tr height="90" style="margin: 0; padding: 0; border: 0;">
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/bottom-1.jpg);">
    			</td>
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/bottom-2.jpg);" width="601">
    			</td>
    			<td style="padding: 0; border: 0; margin: 0; background: #797979 url(images/bottom-3.jpg);">
    			</td>
    		</tr>
    	</table>
	</td>
  </tr>
</table>

</body></html>

		'



        ;
    }

    function have_permission($group_uid, $field) {

        $q = $this->db->query("SELECT * FROM permission WHERE group_uid = $group_uid");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data = $row->$field;
            }
            return $data;
        }
    }

}

?>