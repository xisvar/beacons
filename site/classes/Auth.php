<?php
/**
 * Auth: username and password checks plus the session helpers that store
 * the signed in user and access level. Passwords are stored only as bcrypt
 * hashes and are checked with password_verify().
 */
class Auth
{
    private $users;
    private $roles;

    public function __construct(array $users, array $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    /** Returns the user record (with username) when the login is valid, otherwise null. */
    public function attempt($username, $password)
    {
        $known = isset($this->users[$username]);
        // Always run one hash comparison so a wrong username and a wrong
        // password take about the same time.
        $first = reset($this->users);
        $hash  = $known ? $this->users[$username]['hash'] : $first['hash'];
        $match = password_verify((string) $password, $hash);
        if (!$known || !$match) {
            return null;
        }
        $record = $this->users[$username];
        $record['username'] = $username;
        return $record;
    }

    /** Store the user in the session and rotate the session id. */
    public static function login(array $record)
    {
        session_regenerate_id(true);
        $_SESSION['user'] = array(
            'username' => $record['username'],
            'display'  => $record['display'],
            'role'     => $record['role'],
        );
    }

    /** Remove the login but keep the shopping cart. */
    public static function logout()
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public static function user()
    {
        return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function level($role)
    {
        return isset($this->roles[$role]) ? $this->roles[$role] : 0;
    }

    /** True when the signed in user has at least the given role. */
    public function can($requiredRole)
    {
        $user = self::user();
        if ($user === null) {
            return false;
        }
        return $this->level($user['role']) >= $this->level($requiredRole);
    }
}
