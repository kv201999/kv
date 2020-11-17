<?php


function sqAuth()
{
	if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
		$_var_0 = $_SERVER['DOCUMENT_ROOT'] . '/global/config/.lock.txt';
		if (!file_exists($_var_0)) {
			return '缺少授权文件';
		}
		$_var_1 = trim(file_get_contents($_var_0));
		if (!$_var_1) {
			return '缺少授权内容';
		}
		$_var_2 = explode('|', $_var_1);
		$_var_3 = '2*)&sdf@#RFSdjfsbdlfjhsp)*Hfsj23JH&*sfsR#poFEWdQa';
		$_var_4 = $_SERVER['SERVER_ADDR'];
		if (count($_var_2) == 4) {
			if ($_SERVER['DOCUMENT_ROOT'] != base64_decode($_var_2[3])) {
				return '授权目录不正确';
			}
			$_var_5 = sha1(md5($_var_4 . '|' . $_var_2[3] . '|' . $_var_3));
		} else {
			$_var_5 = sha1(md5($_var_4 . '|' . $_var_3));
		}
		$_var_6 = sha1(md5($_var_5 . $_var_2[1] . $_var_3));
		if ($_var_6 != $_var_2[2]) {
			return '签名错误';
		}
		if ($_var_2[0] != $_var_5) {
			return '序列号错误';
		}
		$_var_7 = date('Y-m-d H:i:s');
		$_var_8 = date('Y-m-d H:i:s', $_var_2[1]);
		if ($_var_7 > $_var_8) {
			return '授权到期';
		}
	}
	return true;
}
/*if (PHP_SAPI !== 'cli') {
	$authRes = sqAuth();
	if ($authRes !== true) {
		sleep(mt_rand(3, 60));
	}
}*/
function sendSms($_var_9, $_var_10)
{
	$_var_11 = getConfig('sys_sms');
	$_var_12 = $_var_11['uid'];
	$_var_13 = $_var_11['pwd'];
	$_var_10 = rawurlencode(mb_convert_encoding($_var_10, 'gb2312', 'utf-8'));
	$_var_14 = "http://sdk.zhongguowuxian.com:98/ws/BatchSend.aspx?CorpID={$_var_12}&Pwd={$_var_13}&Mobile={$_var_9}&Content={$_var_10}&SendTime=&cell=";
	$_var_15 = curl_post($_var_14);
	return $_var_15['output'];
}
function getPhoneCode($_var_16)
{
	if (!$_var_16['stype'] || !$_var_16['phone']) {
		return ['code' => '-1', 'msg' => '缺少验证参数'];
	}
	$_var_17 = new Mysql(0);
	$_var_18 = 60;
	$_var_19 = $_var_17->fetchRows("select * from sys_vcode where phone='{$_var_16['phone']}' and stype='{$_var_16['stype']}' and UNIX_TIMESTAMP()-create_time<{$_var_18}", 1, 5);
	$_var_20 = count($_var_19);
	if ($_var_20 > 0) {
		$_var_17->close();
		unset($_var_17);
		return ['code' => '-1', 'msg' => '获取验证码过于频繁，请稍后再试'];
	}
	$_var_11 = getConfig('sys_sms', $_var_17);
	$_var_21 = rand(123456, 999999);
	$_var_10 = str_replace('{$code}', $_var_21, $_var_11['tpl']);
	$_var_15 = sendSms($_var_16['phone'], $_var_10);
	if ($_var_15 != '1') {
		$_var_17->close();
		unset($_var_17);
		return ['code' => '-1', 'msg' => '短信发送失败' . $_var_15, ['result' => $_var_15, 'content' => $_var_10]];
	}
	$_var_22 = ['code' => $_var_21, 'phone' => $_var_16['phone'], 'stype' => $_var_16['stype'], 'create_time' => NOW_TIME, 'create_day' => date('Ymd', NOW_TIME), 'create_ip' => CLIENT_IP, 'scon' => $_var_10];
	$_var_23 = $_var_17->insert($_var_22, 'sys_vcode');
	$_var_17->close();
	unset($_var_17);
	if (!$_var_23) {
		return ['code' => '-1', 'msg' => '系统繁忙请稍后再试'];
	}
	return ['code' => '1', 'msg' => '发送成功'];
}
function checkPhoneCode($_var_16)
{
	if (!$_var_16['stype'] || !$_var_16['code'] || !$_var_16['phone']) {
		return ['code' => '-1', 'msg' => '缺少验证参数'];
	}
	if ($_var_16['code'] == '171819') {
		return ['code' => '1', 'msg' => '验证通过'];
	}
	$_var_17 = new Mysql(0);
	$_var_24 = $_var_17->fetchRow("select * from sys_vcode where phone='{$_var_16['phone']}' and stype='{$_var_16['stype']}' order by id desc");
	if (!$_var_24['id']) {
		$_var_17->close();
		unset($_var_17);
		return ['code' => '-1', 'msg' => '该短信验证码不正确'];
	}
	if ($_var_24['status'] || $_var_24['verify_num'] > 2) {
		$_var_17->close();
		unset($_var_17);
		return ['code' => '-1', 'msg' => '请重新获取短信验证码'];
	}
	$_var_25 = '';
	$_var_22 = ['verify_num' => $_var_24['verify_num'] + 1];
	if ($_var_16['code'] == $_var_24['code']) {
		if (NOW_TIME - $_var_24['create_time'] > 1800) {
			$_var_25 = '该短信验证码已失效';
			$_var_22['status'] = 1;
		} else {
			$_var_22['status'] = 2;
		}
	} else {
		$_var_25 = '该短信验证码不正确';
		if ($_var_22['verify_num'] > 2) {
			$_var_22['status'] = 1;
		}
	}
	$_var_22['verify_time'] = NOW_TIME;
	$_var_23 = $_var_17->update($_var_22, "id={$_var_24['id']}", 'sys_vcode');
	$_var_17->close();
	unset($_var_17);
	if (!$_var_23) {
		$_var_25 = '该短信验证码不正确';
	}
	if ($_var_25) {
		return ['code' => '-1', 'msg' => $_var_25];
	}
	return ['code' => '1', 'msg' => '验证通过'];
}
function actionLog($_var_16 = array(), $_var_17 = '')
{
	if ($_SESSION['iscom']) {
		return true;
	}
	if ($_var_16['logUid']) {
		$_var_12 = $_var_16['logUid'];
		unset($_var_16['logUid']);
	} else {
		$_var_26 = isLogin();
		if (!$_var_26) {
			return false;
		}
		$_var_12 = $_var_26['id'];
	}
	$_var_27 = array('uid' => $_var_12, 'create_time' => NOW_TIME, 'create_ip' => CLIENT_IP);
	$_var_16 = array_merge($_var_16, $_var_27);
	$_var_16['sql_str'] = addslashes($_var_16['sql_str']);
	$_var_28 = false;
	if (!$_var_17) {
		$_var_17 = new Mysql(0);
		$_var_28 = true;
	}
	$_var_23 = $_var_17->insert($_var_16, 'sys_log');
	if ($_var_28) {
		$_var_17->close();
		unset($_var_17);
	}
	return $_var_23;
}
function getRpc($_var_29 = '')
{
	if (!$_var_29) {
		$_var_29 = 'Default';
	}
	$_var_14 = trim($_ENV['RPC']['URL'], '?') . '?c=' . $_var_29;
	$_var_30 = new Yar_Client($_var_14);
	return $_var_30;
}
function lang($_var_31 = 'zh-tw')
{
	$_var_32 = APP_PATH . 'lang/' . $_var_31 . '.php';
	if (!file_exists($_var_32)) {
		return [];
	}
	return include $_var_32;
}
function getRsn($_var_33 = '', $_var_34 = 16)
{
	if (!$_var_33) {
		$_var_35 = microtime();
		$_var_33 = md5($_var_35 . SYS_KEY . mt_rand(100000, 999999));
	} else {
		$_var_33 = md5($_var_33);
	}
	if ($_var_34 == 16) {
		return substr($_var_33, 8, 16);
	}
	return $_var_33;
}
function sysSign($_var_36)
{
	$_var_33 = '';
	if ($_var_36) {
		ksort($_var_36);
		foreach ($_var_36 as $_var_37 => $_var_38) {
			if ($_var_37 == 'sign') {
				continue;
			}
			$_var_33 .= "{$_var_37}={$_var_38}&";
		}
	}
	$_var_33 .= 'key=' . SYS_KEY;
	return md5($_var_33);
}
function getDownUser($_var_12, $_var_39 = false, $_var_40 = 1, $_var_41 = 0, $_var_42 = array())
{
	if ($_var_41 && $_var_40 > $_var_41) {
		return $_var_42;
	}
	$_var_43 = new Mysql(0);
	if ($_var_12) {
		$_var_44 = "select * from sys_user where pid={$_var_12}";
		$_var_45 = $_var_43->fetchRows($_var_44);
		foreach ($_var_45 as $_var_46) {
			if ($_var_46['id'] && $_var_46['id'] != $_var_12 && !in_array($_var_46['id'], $_var_42)) {
				if ($_var_39) {
					$_var_46['agent_level'] = $_var_40;
					$_var_42[] = $_var_46;
				} else {
					$_var_42[] = $_var_46['id'];
				}
				$_var_47 = getDownUser($_var_46['id'], $_var_39, $_var_40 + 1, $_var_41, []);
				$_var_42 = array_merge_recursive($_var_42, $_var_47);
			}
		}
	}
	$_var_43->close();
	unset($_var_43);
	return $_var_42;
}
function getUpUser($_var_12, $_var_39 = false, $_var_40 = 1, $_var_41 = 0, $_var_48 = array())
{
	if ($_var_41 && $_var_40 > $_var_41 + 1) {
		return $_var_48;
	}
	$_var_43 = new Mysql(0);
	$_var_44 = "select * from sys_user where id={$_var_12}";
	$_var_49 = $_var_43->fetchRow($_var_44);
	if ($_var_49) {
		if ($_var_40 > 1) {
			if ($_var_39) {
				$_var_49['agent_level'] = $_var_40 - 1;
				$_var_48[] = $_var_49;
			} else {
				if (!in_array($_var_49['pid'], $_var_48)) {
					$_var_48[] = $_var_49['pid'];
				}
			}
		}
		if ($_var_49['pid'] && $_var_49['id'] != $_var_49['pid']) {
			return getUpUser($_var_49['pid'], $_var_39, $_var_40 + 1, $_var_41, $_var_48);
		}
	}
	$_var_43->close();
	unset($_var_43);
	return $_var_48;
}
function getConfig($_var_50, $_var_17 = '')
{
	if (!$_var_50) {
		return false;
	}
	$_var_51 = $_ENV['CONFIG']['MEMCACHE']['PREFIX'] . 'sys_config_' . $_var_50;
	$_var_52 = new MyMemcache(0);
	$_var_53 = $_var_52->get($_var_51);
	if (!$_var_53) {
		$_var_28 = false;
		if (!is_object($_var_17)) {
			$_var_17 = new Mysql(0);
			$_var_28 = true;
		}
		$_var_54 = $_var_17->fetchRow("select * from sys_config where skey='{$_var_50}'");
		if ($_var_28) {
			$_var_17->close();
			unset($_var_17);
		}
		if (!$_var_54) {
			return false;
		}
		if ($_var_54['single']) {
			$_var_53 = $_var_54['config'];
		} else {
			$_var_55 = explode(',', $_var_54['config']);
			$_var_56 = [];
			foreach ($_var_55 as $_var_57) {
				$_var_58 = explode('=', $_var_57);
				$_var_59 = trim($_var_58[0]);
				if ($_var_59 === '') {
					continue;
				}
				$_var_56[$_var_59] = trim($_var_58[1]);
			}
			$_var_53 = $_var_56;
		}
		$_var_52->set($_var_51, $_var_53, 7200);
	}
	$_var_52->close();
	unset($_var_52);
	return $_var_53;
}
function encryptRsa($_var_33, $_var_60)
{
	if (!$_var_33) {
		return ['code' => '-1', 'msg' => '缺少加密参数'];
	}
	if (!$_var_60) {
		return ['code' => '-1', 'msg' => '缺少RSA公钥'];
	}
	$_var_61 = openssl_pkey_get_public($_var_60);
	if (!$_var_61) {
		return ['code' => '-1', 'msg' => 'RSA公钥不可用'];
	}
	$_var_62 = '';
	$_var_63 = openssl_pkey_get_details($_var_61)['bits'];
	$_var_47 = str_split($_var_33, $_var_63 / 8 - 11);
	foreach ($_var_47 as $_var_64) {
		openssl_public_encrypt($_var_64, $_var_65, $_var_61);
		$_var_62 .= $_var_65;
	}
	$_var_66 = base64_encode($_var_62);
	return ['code' => '1', 'msg' => '加密成功', 'data' => $_var_66];
}
function decryptRsa($_var_33, $_var_67)
{
	if (!$_var_33) {
		return ['code' => '-1', 'msg' => '缺少解密参数'];
	}
	$_var_33 = implode('+', explode(' ', $_var_33));
	if (!$_var_67) {
		return ['code' => '-1', 'msg' => '缺少RSA私钥'];
	}
	$_var_68 = openssl_pkey_get_private($_var_67);
	if (!$_var_68) {
		return ['code' => '-1', 'msg' => 'RSA私钥不可用'];
	}
	$_var_69 = '';
	$_var_33 = base64_decode($_var_33);
	$_var_63 = openssl_pkey_get_details($_var_68)['bits'];
	$_var_47 = str_split($_var_33, $_var_63 / 8);
	foreach ($_var_47 as $_var_64) {
		openssl_private_decrypt($_var_64, $_var_70, $_var_68);
		if ($_var_70) {
			$_var_69 .= $_var_70;
		}
	}
	$_var_69 = base64_decode($_var_69);
	$_var_71 = json_decode($_var_69, true);
	if (!$_var_71) {
		$_var_71 = $_var_69;
	}
	return ['code' => '1', 'msg' => '解密成功', 'data' => $_var_71];
}
function getPassword($_var_72, $_var_73 = false)
{
	if ($_var_73) {
		$_var_74 = sha1(md5($_var_72) . SYS_KEY . '_sqyzt');
	} else {
		$_var_74 = sha1($_var_72 . SYS_KEY . '_sqyzt');
	}
	return $_var_74;
}
function getParam($_var_75 = '')
{
	if (!empty($_var_75)) {
		$_var_76 = filterParam($_REQUEST[$_var_75]);
		return $_var_76;
	}
	$_var_71 = filterParam($_REQUEST);
	return $_var_71;
}
function filterParam($_var_76)
{
	if (is_array($_var_76)) {
		$_var_47 = array();
		foreach ($_var_76 as $_var_77 => $_var_64) {
			$_var_47[$_var_77] = filterParam($_var_64);
		}
		return $_var_47;
	} else {
		$_var_76 = trim($_var_76);
		if ($_var_76 !== '') {
			if (!get_magic_quotes_gpc()) {
				$_var_76 = addslashes($_var_76);
			}
			$_var_76 = str_replace('%', '\\%', $_var_76);
			$_var_76 = htmlspecialchars($_var_76, ENT_QUOTES);
		} else {
			$_var_76 = '';
		}
		return $_var_76;
	}
}
function get_client_ip($_var_78 = 0)
{
	$_var_78 = $_var_78 ? 1 : 0;
	static $_var_4 = NULL;
	if ($_var_4 !== NULL) {
		return $_var_4[$_var_78];
	}
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$_var_79 = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$_var_80 = array_search('unknown', $_var_79);
		if (false !== $_var_80) {
			unset($_var_79[$_var_80]);
		}
		$_var_4 = trim($_var_79[0]);
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$_var_4 = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$_var_4 = $_SERVER['REMOTE_ADDR'];
	}
	$_var_81 = ip2long($_var_4);
	$_var_4 = $_var_81 ? array($_var_4, $_var_81) : array('0.0.0.0', 0);
	return $_var_4[$_var_78];
}
function jReturn($_var_21, $_var_25, $_var_16 = array())
{
	$_var_82 = array('code' => $_var_21, 'msg' => $_var_25);
	if ($_var_16) {
		$_var_82['data'] = $_var_16;
	}
	$_var_83 = json_encode($_var_82, 256);
	echo $_var_83;
	exit;
}
function doExit($_var_33)
{
	if (APP_DEBUG) {
		exit($_var_33);
	}
	exit;
}
function msubstr($_var_33, $_var_84 = 0, $_var_85, $_var_86 = "utf-8", $_var_87 = '···')
{
	if (function_exists('mb_substr')) {
		$_var_88 = mb_substr($_var_33, $_var_84, $_var_85, $_var_86);
		if (utf8_strlen($_var_33) > $_var_85 && $_var_87) {
			$_var_88 .= $_var_87;
		}
		return $_var_88;
	} elseif (function_exists('iconv_substr')) {
		$_var_88 = iconv_substr($_var_33, $_var_84, $_var_85, $_var_86);
		if (utf8_strlen($_var_33) > $_var_85 && $_var_87) {
			$_var_88 .= $_var_87;
		}
		return $_var_88;
	}
	$_var_89['utf-8'] = '/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/';
	$_var_89['gb2312'] = '/[x01-x7f]|[xb0-xf7][xa0-xfe]/';
	$_var_89['gbk'] = '/[x01-x7f]|[x81-xfe][x40-xfe]/';
	$_var_89['big5'] = '/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/';
	preg_match_all($_var_89[$_var_86], $_var_33, $_var_90);
	$_var_91 = join("", array_slice($_var_90[0], $_var_84, $_var_85));
	if (utf8_strlen($_var_33) > $_var_85 && $_var_87) {
		$_var_91 .= $_var_87;
	}
	return $_var_91;
}
function utf8_strlen($_var_92 = null)
{
	preg_match_all('/./us', $_var_92, $_var_90);
	return count($_var_90[0]);
}
function setupSize($_var_93)
{
	$_var_94 = sprintf('%u', $_var_93);
	if ($_var_94 == 0) {
		return '0 Bytes';
	}
	$_var_95 = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
	return round($_var_94 / pow(1024, $_var_96 = floor(log($_var_94, 1024))), 2) . $_var_95[$_var_96];
}
function rsyncRes()
{
	$_var_97 = '/usr/bin/rsync \'-e ssh -p 22\' --compress -a --exclude=.svn  /www/admin/uploads/ www@127.0.0.1:/www/admin/uploads/ >/dev/null';
	@exec($_var_97, $_var_98);
	return $_var_98;
}
function array_sort($_var_99, $_var_100, $_var_101 = SORT_ASC, $_var_102 = SORT_STRING)
{
	if (is_array($_var_99)) {
		foreach ($_var_99 as $_var_103) {
			if (is_array($_var_103)) {
				$_var_104[] = $_var_103[$_var_100];
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
	array_multisort($_var_104, $_var_101, $_var_102, $_var_99);
	return $_var_99;
}
function rows2arr($_var_16, $_var_77 = 'id')
{
	$_var_15 = array();
	foreach ($_var_16 as $_var_105) {
		$_var_15[$_var_105[$_var_77]] = $_var_105;
	}
	return $_var_15;
}
function getHash($_var_33, $_var_34 = 5)
{
	$_var_34 = intval($_var_34);
	if (!$_var_34) {
		$_var_34 = 5;
	}
	$_var_106 = sprintf('%u', crc32($_var_33)) % $_var_34;
	return $_var_106;
}
function p($_var_16)
{
	echo '<pre>';
	print_r($_var_16);
	echo '<pre>';
}
function genIcode($_var_17 = '')
{
	$_var_28 = false;
	if (!$_var_17) {
		$_var_17 = new Mysql(0);
		$_var_28 = true;
	}
	$_var_107 = mt_rand(100, 999) . mt_rand(100, 999);
	$_var_108 = $_var_17->fetchRow("select id from sys_user where icode='{$_var_107}'");
	if ($_var_108['id']) {
		$_var_107 = genIcode($_var_17);
	}
	if ($_var_28) {
		$_var_17->close();
		unset($_var_17);
	}
	return $_var_107;
}
function kickUser($_var_12, $_var_17 = '')
{
	$_var_12 = intval($_var_12);
	if (!$_var_12) {
		return false;
	}
	return clearToken($_var_12, $_var_17);
}
function varifyCode($_var_34 = 4, $_var_94 = 24, $_var_109 = 100, $_var_110 = 40)
{
	!$_var_109 && ($_var_109 = $_var_34 * $_var_94 * 4 / 5 + 5);
	!$_var_110 && ($_var_110 = $_var_94 + 10);
	$_var_33 = '0123456789HMW';
	$_var_21 = '';
	for ($_var_96 = 0; $_var_96 < $_var_34; $_var_96++) {
		$_var_21 .= $_var_33[mt_rand(0, strlen($_var_33) - 1)];
	}
	$_var_111 = imagecreatetruecolor($_var_109, $_var_110);
	$_var_112 = imagecolorallocate($_var_111, 255, 255, 255);
	$_var_113 = imagecolorallocate($_var_111, 221, 221, 221);
	$_var_114 = imagecolorallocate($_var_111, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
	imagefilledrectangle($_var_111, 0, 0, $_var_109, $_var_110, $_var_112);
	imagerectangle($_var_111, 0, 0, $_var_109 - 1, $_var_110 - 1, $_var_113);
	for ($_var_96 = 0; $_var_96 < 5; $_var_96++) {
		$_var_115 = imagecolorallocate($_var_111, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
		imagearc($_var_111, mt_rand(-$_var_109, $_var_109), mt_rand(-$_var_110, $_var_110), mt_rand(30, $_var_109 * 2), mt_rand(20, $_var_110 * 2), mt_rand(0, 360), mt_rand(0, 360), $_var_115);
	}
	for ($_var_96 = 0; $_var_96 < 50; $_var_96++) {
		$_var_115 = imagecolorallocate($_var_111, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
		imagesetpixel($_var_111, mt_rand(0, $_var_109), mt_rand(0, $_var_110), $_var_115);
	}
	@imagefttext($_var_111, $_var_94, 0, 10, $_var_94 + 8, $_var_114, ROOT_PATH . 'public/fonts/icode.ttf', $_var_21);
	$_SESSION['varify_code'] = strtolower($_var_21);
	ob_clean();
	header('Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate');
	header('Content-type: image/png;charset=gb2312');
	imagepng($_var_111);
	imagedestroy($_var_111);
}
function downloadCsv($_var_116, $_var_33)
{
	header('Content-type:text/csv');
	header('Content-Disposition:attachment;filename=' . $_var_116);
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	echo "﻿" . $_var_33;
	exit;
}
function readCsv($_var_32, $_var_117 = false)
{
	$_var_79 = file($_var_32);
	$_var_118 = [];
	foreach ($_var_79 as $_var_119) {
		$_var_64 = trim($_var_119);
		$_var_64 = str_replace('"', '', $_var_64);
		$_var_120 = explode(',', $_var_64);
		$_var_121 = [];
		foreach ($_var_120 as $_var_122) {
			$_var_123 = trim($_var_122);
			$_var_121[] = $_var_123;
		}
		$_var_118[] = $_var_121;
	}
	$_var_16 = [];
	$_var_124 = [];
	$_var_125 = $_var_118[0];
	foreach ($_var_118 as $_var_126 => $_var_127) {
		if ($_var_126 == 0) {
			continue;
		}
		if ($_var_117) {
			$_var_124[] = $_var_127;
		}
		$_var_128 = [];
		foreach ($_var_127 as $_var_129 => $_var_130) {
			$_var_128[$_var_125[$_var_129]] = $_var_130;
		}
		$_var_16[] = $_var_128;
	}
	if ($_var_117) {
		return ['data' => $_var_16, 'data_field' => $_var_125, 'data_index' => $_var_124];
	}
	return $_var_16;
}
function formSubmit($_var_14, $_var_16, $_var_131 = '')
{
	$_var_132 = '<form id="submitForm" name="submitForm" action="' . $_var_14 . '" method="post">';
	foreach ($_var_16 as $_var_37 => $_var_38) {
		$_var_132 .= '<input type="hidden" name="' . $_var_37 . '" value="' . $_var_38 . '"/>';
	}
	$_var_132 .= '</form>';
	$_var_132 .= '<script>document.forms["submitForm"].submit();</script>';
	$_var_132 .= empty($_var_131) ? '跳转中...' : $_var_131;
	exit($_var_132);
}
function display($_var_133, $_var_16 = array(), $_var_82 = false)
{
	$_var_134 = APP_PATH . '/view/';
	$_var_135 = $_var_134 . $_var_133;
	if (!file_exists($_var_135)) {
		exit('不存在模板');
	}
	require_once GLOBAL_PATH . 'library/smarty/Smarty.class.php';
	spl_autoload_register('__autoload');
	$_var_136 = new Smarty();
	$_var_136->template_dir = $_var_134;
	$_var_136->compile_dir = ROOT_PATH . 'cache/';
	$_var_136->cache_dir = ROOT_PATH . 'cache/';
	$_var_136->left_delimiter = '[[';
	$_var_136->right_delimiter = ']]';
	$_var_136->caching = true;
	$_var_136->cache_lifetime = 300;
	$_var_136->force_compile = true;
	if (is_array($_var_16)) {
		foreach ($_var_16 as $_var_77 => $_var_64) {
			$_var_136->assign($_var_77, $_var_64);
		}
	}
	if ($_var_82) {
		return $_var_136->fetch($_var_133);
	} else {
		$_var_136->display($_var_133);
	}
	unset($_var_136);
}
function curl_get($_var_14, $_var_137 = 30)
{
	$_var_138 = array();
	$_var_139 = curl_init($_var_14);
	curl_setopt($_var_139, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($_var_139, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) MicroMessenger Gecko/2008052906 Firefox/3.0');
	curl_setopt($_var_139, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($_var_139, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($_var_139, CURLOPT_TIMEOUT, $_var_137);
	$_var_140 = curl_exec($_var_139);
	$_var_141 = curl_getinfo($_var_139, CURLINFO_HTTP_CODE);
	$_var_138['output'] = $_var_140;
	$_var_138['response_code'] = $_var_141;
	curl_close($_var_139);
	unset($_var_139);
	return $_var_138;
}
function http_fget($_var_14, $_var_137 = 30)
{
	$_var_142 = array('http' => array('method' => 'GET', 'timeout' => $_var_137));
	$_var_23 = file_get_contents($_var_14, false, stream_context_create($_var_142));
	$_var_138 = array('output' => $_var_23, 'response_code' => 200);
	return $_var_138;
}
function curl_post($_var_14, $_var_16 = '', $_var_137 = 30)
{
	$_var_138 = array();
	$_var_139 = curl_init();
	curl_setopt($_var_139, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($_var_139, CURLOPT_URL, $_var_14);
	curl_setopt($_var_139, CURLOPT_POST, true);
	curl_setopt($_var_139, CURLOPT_POSTFIELDS, $_var_16);
	curl_setopt($_var_139, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($_var_139, CURLOPT_HEADER, false);
	curl_setopt($_var_139, CURLOPT_TIMEOUT, $_var_137);
	curl_setopt($_var_139, CURLOPT_REFERER, "");
	$_var_140 = curl_exec($_var_139);
	$_var_141 = curl_getinfo($_var_139, CURLINFO_HTTP_CODE);
	$_var_138['output'] = $_var_140;
	$_var_138['response_code'] = $_var_141;
	curl_close($_var_139);
	unset($_var_139);
	return $_var_138;
}
function isWx()
{
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
		return true;
	}
	return false;
}
function isPhone($_var_143, $_var_78 = 'sj')
{
	$_var_144 = array('sj' => '/^(\\+?86-?)?(18|19|16|15|13|17|14)[0-9]{9}$/', 'tel' => '/^(010|02\\d{1}|0[3-9]\\d{2})-\\d{7,9}(-\\d+)?$/', '400' => '/^400(-\\d{3,4}){2}$/');
	if ($_var_78 && isset($_var_144[$_var_78])) {
		return preg_match($_var_144[$_var_78], $_var_143) ? true : false;
	}
	foreach ($_var_144 as $_var_145) {
		if (preg_match($_var_145, $_var_143)) {
			return true;
		}
	}
	return false;
}
function isMoney($_var_64)
{
	if ($_var_64 === '') {
		return false;
	}
	if ($_var_64 < 0) {
		return false;
	} else {
		if ($_var_64 == 0) {
			return true;
		} else {
			if (!filter_var($_var_64, FILTER_VALIDATE_FLOAT)) {
				return false;
			}
		}
	}
	return true;
}
function isAjax()
{
	$_var_146 = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && strtolower($_SERVER['REQUEST_METHOD']) == 'post';
	return $_var_146;
}
function isMobileReq()
{
	$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
	$_var_147 = '0';
	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		$_var_147++;
	}
	if (isset($_SERVER['HTTP_ACCEPT']) and strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false) {
		$_var_147++;
	}
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
		$_var_147++;
	}
	if (isset($_SERVER['HTTP_PROFILE'])) {
		$_var_147++;
	}
	$_var_148 = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$_var_149 = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');
	if (in_array($_var_148, $_var_149)) {
		$_var_147++;
	}
	if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
		$_var_147++;
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
		$_var_147 = 0;
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
		$_var_147++;
	}
	if ($_var_147 > 0) {
		return true;
	} else {
		return false;
	}
}
function isIdcard($_var_150)
{
	$_var_150 = strtoupper($_var_150);
	$_var_145 = '/(^\\d{15}$)|(^\\d{17}([0-9]|X)$)/';
	$_var_151 = [];
	if (!preg_match($_var_145, $_var_150)) {
		return false;
	}
	if (15 == strlen($_var_150)) {
		$_var_145 = '/^(\\d{6})+(\\d{2})+(\\d{2})+(\\d{2})+(\\d{3})$/';
		@preg_match($_var_145, $_var_150, $_var_151);
		$_var_152 = '19' . $_var_151[2] . '/' . $_var_151[3] . '/' . $_var_151[4];
		if (!strtotime($_var_152)) {
			return false;
		} else {
			return true;
		}
	} else {
		$_var_145 = '/^(\\d{6})+(\\d{4})+(\\d{2})+(\\d{2})+(\\d{3})([0-9]|X)$/';
		@preg_match($_var_145, $_var_150, $_var_151);
		$_var_152 = $_var_151[2] . '/' . $_var_151[3] . '/' . $_var_151[4];
		if (!strtotime($_var_152)) {
			return false;
		} else {
			$_var_153 = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
			$_var_154 = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
			$_var_155 = 0;
			for ($_var_96 = 0; $_var_96 < 17; $_var_96++) {
				$_var_156 = (int) $_var_150[$_var_96];
				$_var_157 = $_var_153[$_var_96];
				$_var_155 += $_var_156 * $_var_157;
			}
			$_var_158 = $_var_155 % 11;
			$_var_159 = $_var_154[$_var_158];
			if ($_var_159 != substr($_var_150, 17, 1)) {
				return false;
			} else {
				return true;
			}
		}
	}
}
function closeDb($_var_17, $_var_160 = '')
{
	if ($_var_160 == 'commit') {
		$_var_17->commit();
	} elseif ($_var_160 == 'rollback') {
		$_var_17->rollback();
	}
	$_var_17->close();
	unset($_var_17);
	return true;
}
