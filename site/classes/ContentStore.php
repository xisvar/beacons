<?php
/**
 * ContentStore: field update posts written on the Publisher Desk.
 * Posts live in $_SESSION['posts'] in this assignment. Each post already has
 * the columns a database table would use (id, title, body, field, status,
 * author, created), so the final assignment can swap the session for SQL.
 */
class ContentStore
{
    public function __construct()
    {
        if (!isset($_SESSION['posts']) || !is_array($_SESSION['posts'])) {
            $_SESSION['posts'] = array();
        }
        if (!isset($_SESSION['post_seq'])) {
            $_SESSION['post_seq'] = 0;
        }
    }

    public function create($title, $body, $field, $author)
    {
        $_SESSION['post_seq']++;
        $id = $_SESSION['post_seq'];
        $_SESSION['posts'][$id] = array(
            'id'      => $id,
            'title'   => trim($title),
            'body'    => trim($body),
            'field'   => $field,
            'status'  => 'draft',
            'author'  => $author,
            'created' => date('Y-m-d H:i'),
        );
        return $id;
    }

    public function all()
    {
        return array_reverse($_SESSION['posts'], true);
    }

    public function published()
    {
        $out = array();
        foreach ($this->all() as $id => $post) {
            if ($post['status'] === 'published') {
                $out[$id] = $post;
            }
        }
        return $out;
    }

    public function setStatus($id, $status)
    {
        $id = (int) $id;
        if (!isset($_SESSION['posts'][$id]) || !in_array($status, array('draft', 'published'), true)) {
            return false;
        }
        $_SESSION['posts'][$id]['status'] = $status;
        return true;
    }

    public function remove($id)
    {
        $id = (int) $id;
        if (!isset($_SESSION['posts'][$id])) {
            return false;
        }
        unset($_SESSION['posts'][$id]);
        return true;
    }
}
