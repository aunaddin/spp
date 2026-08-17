<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function create($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function get_all_by_role($role)
    {
        return $this->db->get_where('users', ['role' => $role])->result();
    }

    public function get_all_users($keyword = null, $limit = null, $offset = 0)
    {
        $this->db->order_by('role', 'ASC')->order_by('nama', 'ASC');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('username', $keyword);
            $this->db->or_like('nama', $keyword);
            $this->db->or_like('role', $keyword);
            $this->db->group_end();
        }

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('users')->result();
    }

    public function count_all_users($keyword = null)
    {
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('username', $keyword);
            $this->db->or_like('nama', $keyword);
            $this->db->or_like('role', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results('users');
    }
    public function delete($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function is_username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }

    public function update_profil($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function set_reset_token($user_id, $token, $expiry)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', [
            'reset_token'        => $token,
            'reset_token_expiry' => $expiry,
        ]);
    }

    public function get_by_reset_token($token)
    {
        $this->db->where('reset_token', $token);
        $this->db->where('reset_token_expiry >', date('Y-m-d H:i:s'));
        return $this->db->get('users')->row();
    }

    public function clear_reset_token($user_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', [
            'reset_token'        => NULL,
            'reset_token_expiry' => NULL,
        ]);
    }
}