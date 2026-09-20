<?php
/**
 * Validator: reusable checks for form fields and passwords.
 * Every method is static and returns true or false (or a list of checks).
 */
class Validator
{
    public static function required($value)
    {
        return trim((string) $value) !== '';
    }

    public static function email($value)
    {
        $value = trim((string) $value);
        return strlen($value) <= 254 && strpos($value, '@') !== false && filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function lengthBetween($value, $min, $max)
    {
        $len = strlen(trim((string) $value));
        return $len >= $min && $len <= $max;
    }

    /** Letters, spaces, apostrophes, periods, and hyphens (personal names). */
    public static function personName($value)
    {
        return (bool) preg_match("/^[A-Za-z][A-Za-z .'\\-]{1,59}$/", trim((string) $value));
    }

    public static function digitsOnly($value)
    {
        return (bool) preg_match('/^[0-9]+$/', (string) $value);
    }

    /** Whole number between two limits, digits only. */
    public static function intBetween($value, $min, $max)
    {
        $value = trim((string) $value);
        return self::digitsOnly($value) && (int) $value >= $min && (int) $value <= $max;
    }

    /** 7 to 15 digits, allowing spaces, dashes, dots, parentheses and a leading plus. */
    public static function phone($value)
    {
        $value = trim((string) $value);
        if (!preg_match('/^\+?[0-9 ().\-]{7,20}$/', $value)) {
            return false;
        }
        $digits = strlen(preg_replace('/[^0-9]/', '', $value));
        return $digits >= 7 && $digits <= 15;
    }

    public static function postalCode($value)
    {
        return (bool) preg_match('/^[A-Za-z0-9][A-Za-z0-9 \-]{2,9}$/', trim((string) $value));
    }

    public static function username($value)
    {
        return (bool) preg_match('/^[A-Za-z][A-Za-z0-9_]{3,19}$/', (string) $value);
    }

    /** Date in YYYY-MM-DD form that is a real calendar date. */
    public static function date($value)
    {
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', (string) $value, $m)) {
            return false;
        }
        return checkdate((int) $m[2], (int) $m[3], (int) $m[1]);
    }

    public static function inList($value, array $allowed)
    {
        return in_array($value, $allowed, true);
    }

    /**
     * Password strength rules. Returns a list of rows, each with a label
     * and whether the password passed that rule.
     * @param string[] $commonPasswords weak passwords that are never accepted
     */
    public static function passwordChecks($password, $username, array $commonPasswords)
    {
        $lower = strtolower($password);
        $checks = array();
        $checks[] = array('label' => 'At least 10 characters long',                'passed' => strlen($password) >= 10);
        $checks[] = array('label' => 'No more than 64 characters',                 'passed' => strlen($password) <= 64);
        $checks[] = array('label' => 'Contains an uppercase letter (A to Z)',      'passed' => (bool) preg_match('/[A-Z]/', $password));
        $checks[] = array('label' => 'Contains a lowercase letter (a to z)',       'passed' => (bool) preg_match('/[a-z]/', $password));
        $checks[] = array('label' => 'Contains a number (0 to 9)',                 'passed' => (bool) preg_match('/[0-9]/', $password));
        $checks[] = array('label' => 'Contains a symbol such as ! ? # $ % &',      'passed' => (bool) preg_match('/[^A-Za-z0-9]/', $password));
        $checks[] = array('label' => 'Contains no spaces',                         'passed' => !preg_match('/\s/', $password));
        $checks[] = array('label' => 'Does not contain your username',             'passed' => $username === '' || stripos($password, $username) === false);
        $checks[] = array('label' => 'Is not a commonly used password',            'passed' => !in_array($lower, $commonPasswords, true));
        return $checks;
    }

    /** Count of rules passed, used to draw the strength meter. */
    public static function passedCount(array $checks)
    {
        $count = 0;
        foreach ($checks as $check) {
            if ($check['passed']) {
                $count++;
            }
        }
        return $count;
    }

    public static function allPassed(array $checks)
    {
        return self::passedCount($checks) === count($checks);
    }
}
