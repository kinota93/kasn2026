<?php
class UserLdap {
    const ldap_host = "ldap1.ip.kyusan-u.ac.jp";
    const ldap_base = "ou=userall,dc=kyusan-u,dc=ac,dc=jp";

    const LDAP_ENTRIES = [
        #LDAP ENTRY => New NAME
        'uid'=>'uid',//※ユーザID
        'sambasid'=>'sid',//※学籍番号・職員番号
    ];
    const LDAP_NAMES=[
        'uid'=>'ログインID',
        'sid'=>'会員番号',
    ];
    public function check($userid, $passwd)
    {
        $dn = "uid=" . $userid . "," . self::ldap_base;
        $ldap = ldap_connect(self::ldap_host);
        
        if(!$ldap) return false;
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        // Add to avoid timeout
        ldap_set_option($ldap, LDAP_OPT_NETWORK_TIMEOUT, 10);
        ldap_set_option($ldap, LDAP_OPT_TIMELIMIT, 10);
        $ldap_bind = @ldap_bind($ldap, $dn, $passwd);
        if(!$ldap_bind)  return false;
        
        $filter = "uid={$userid}";
        $result = ldap_search($ldap, self::ldap_base, $filter);
        if (ldap_count_entries($ldap, $result) > 0)
            return true;
        return false;
    }
}
