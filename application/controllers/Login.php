<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        // Set the timezone
        date_default_timezone_set(get_settings('timezone'));
    }

    public function index()
    {
        if ($this->session->userdata('admin_login') == true) {
            redirect(site_url('admin/dashboard'), 'refresh');
        } elseif ($this->session->userdata('user_login') == true) {
            redirect(site_url('user/dashboard'), 'refresh');
        } else {
            redirect(site_url('home/login'), 'refresh');
        }
    }

    public function validate_login($from = "")
    {
        $email = sanitizer($this->input->post('email'));
        $password = sanitizer($this->input->post('password'));
        $credential = array('email' => $email, 'password' => sha1($password), 'is_verified' => 1);
        // echo sha1($password);

        // Checking login credential for admin
        $query = $this->db->get_where('user', $credential);
        // print_r($query);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('is_logged_in', 1);
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('phone', $row->phone);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                redirect(site_url('admin/dashboard'), 'refresh');
            } else if ($row->role_id == 2) {
                $this->session->set_userdata('user_login', '1');
                redirect(site_url('user/dashboard'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', get_phrase('provided_credentials_are_invalid'));
            redirect(site_url('home/login'), 'refresh');
        }
    }

    public function phone_login_validation()
    {
        $phone = sanitizer($this->input->post('phone'));
        $login_details = array(
            // 'email' =>  $email,
            'phone' =>  $phone,
            // 'is_verified'   =>  1,
        );

        // Checking login credential for user
        $query = $this->db->get_where('user', $login_details);

        if ($query->num_rows() > 0) {
            $user_otp = array(
                // 'otp'   => random_string('alnum', 6),
                'otp'   => rand(000000, 999999),
            );
            $this->db->where('phone', $login_details['phone']);
            $this->db->update('user', $user_otp);

            $message = 'Your OTP Is: ' . $user_otp['otp'];
            $message_details = send_sms($message, $phone);

            $row = $query->row();
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('email', $row->email);
            $this->session->set_userdata('phone', $row->phone);
            $this->session->set_userdata('ip', $this->input->ip_address());

            $this->session->set_flashdata('flash_message', 'OTP Sent Successfully');
            redirect(site_url('home/otp_verification'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', get_phrase('phone_and_email_doesnot_match_to_a_same_accout'));
            redirect(site_url('home/phone_login'), 'refresh');
        }
    }

    public function resend_otp()
    {
        $login_details = array(
            'phone' =>  $this->session->userdata('phone'),
        );

        // Checking login credential for user
        $query = $this->db->get_where('user', $login_details);

        if ($query->num_rows() > 0) {
            $user_otp = array(
                // 'otp'   => random_string('alnum', 6),
                'otp'   => rand(000000, 999999),
            );
            $this->db->where('phone', $login_details['phone']);
            $this->db->update('user', $user_otp);

            $message = 'Your OTP Is: ' . $user_otp['otp'];
            $message_details = send_sms($message, $this->session->userdata('phone'));

            $row = $query->row();
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('email', $row->email);
            $this->session->set_userdata('phone', $row->phone);
            $this->session->set_userdata('ip', $this->input->ip_address());

            $this->session->set_flashdata('flash_message', 'OTP Resent');
            redirect(site_url('home/otp_verification'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', get_phrase('phone_and_email_doesnot_match_to_a_same_accout'));
            redirect(site_url('home/phone_login'), 'refresh');
        }
    }

    public function otp_check()
    {
        $otp = sanitizer($this->input->post('otp'));
        $verify_otp = array(
            'otp'   =>  $otp,
            'phone' =>  $this->session->userdata('phone'),
        );

        $query = $this->db->get_where('user', $verify_otp);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('is_logged_in', 1);
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('email', $row->email);
            $this->session->set_userdata('ip', $this->input->ip_address());

            $this->db->where('phone', $verify_otp['phone']);
            $this->db->update('user', array('is_verified' => 1));

            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                redirect(site_url('admin/dashboard'), 'refresh');
            } else if ($row->role_id == 2) {
                $this->session->set_userdata('user_login', '1');
                redirect(site_url('user/dashboard'), 'refresh');
            }
        } else {
            $attempt = $this->session->userdata('attempt');
            $attempt++;
            $this->session->set_userdata('attempt', $attempt);

            if ($this->session->userdata('attempt') > 3) {
                $this->session->set_userdata('time', time());
                $this->session->set_flashdata('error_message', 'Your Account has been locked out for 24 hours');
                redirect(site_url('home/login'), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', 'OTP is Incorrect');
                redirect(site_url('home/otp_verification'), 'refresh');
            }
        }
    }

    public function register_user()
    {
        $email = sanitizer($this->input->post('email'));
        $name = sanitizer($this->input->post('name'));
        $password = sha1(sanitizer($this->input->post('password')));
        $address = sanitizer($this->input->post('address'));
        // $phone = sanitizer($this->input->post('phone'));

        if (empty($email) || empty($name) || empty($password) || empty($address)) {
            $this->session->set_flashdata('error_message', get_phrase('fill_in_all_the_fields'));
            redirect(site_url('home/login'), 'refresh');
        }

        $user_added = $this->user_model->add_user();
        if ($user_added == get_phrase('user_registration_successfully_done')) {
            redirect(site_url('home/login'), 'refresh');
        } else {
            redirect(site_url('home/sign_up'), 'refresh');
        }
    }

    public function register_user_with_phone()
    {
        $name = sanitizer($this->input->post('name'));
        $address = sanitizer($this->input->post('address'));
        $phone = sanitizer($this->input->post('phone'));

        if (empty($name) || empty($address) || empty($phone)) {
            $this->session->set_flashdata('error_message', get_phrase('fill_in_all_the_fields'));
            redirect(site_url('home/sign_up_using_phone'), 'refresh');
        }

        $user_added = $this->user_model->add_user_using_phone();
        // if ($user_added == get_phrase('this_phone_number_has_been_taken')) {
        //     redirect(site_url('home/sign_up_using_phone'), 'refresh');
        // } else {
        //     redirect(site_url('home/otp_verification'), 'refresh');
        // }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('home/login'), 'refresh');
    }

    function forgot_password($from = "")
    {
        $email = sanitizer($this->input->post('email'));
        //resetting user password here
        $new_password = substr(md5(rand(100000000, 20000000000)), 0, 7);

        // Checking credential for admin
        $query = $this->db->get_where('user', array('email' => $email));
        if ($query->num_rows() > 0) {
            $this->db->where('email', $email);
            $this->db->update('user', array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password, $email);
            $this->session->set_flashdata('flash_message', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('home/login'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', get_phrase('password_reset_failed'));
            redirect(site_url('home/login'), 'refresh');
        }
    }

    // function for user verification
    public function verify_email_address($verification_code = "")
    {
        $user_details = $this->db->get_where('user', array('verification_code' => $verification_code));
        if ($user_details->num_rows() == 0) {
            $this->session->set_flashdata('error_message', get_phrase('verification_failed'));
        } else {
            $user_details = $user_details->row_array();
            $updater = array(
                'is_verified' => 1
            );
            $this->db->where('id', $user_details['id']);
            $this->db->update('user', $updater);
            $this->session->set_flashdata('flash_message', get_phrase('congratulations') . '!' . get_phrase('your_email_address_has_been_successfully_verified') . '.');
        }
        redirect(site_url('home'), 'refresh');
    }
}
