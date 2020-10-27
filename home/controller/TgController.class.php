<?php
!defined('ROOT_PATH') && exit;
class TgController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function _index(){
		$pageuser=checkLogin();
        $tg_img=$this->genCover($pageuser,true);
        if(!$tg_img){
            jReturn('-1','生成推广海报失败');
        }		
		$data=[
			'title'=>'推荐二维码',
			'tg_img'=>$tg_img.'?rt='.mt_rand(11111,99999),
			'tg_url'=>$this->getQrcodeUrl($pageuser['icode'])
		];
		$this->display($data);
    }
	
	//二维码跳转
	public function _qrcode(){
		//校验二维码有效期
		$params=$this->params;
		$p_data=[
			'icode'=>$params['icode'],
			'time'=>$params['time']
		];
		$sign=sysSign($p_data);
		if($sign!=$params['sign']){
			exit('<div style="font-size:3.5rem;text-align:center;padding-top:40%;">签名错误<div>');
		}
		$cnf_tgqrcode_time=intval(getConfig('cnf_tgqrcode_time'));
		if(abs(NOW_TIME-$params['time'])>$cnf_tgqrcode_time){
			exit('<div style="font-size:3.5rem;text-align:center;padding-top:40%;">该二维码已失效<div>');
		}
		$icode=$params['icode'];
		$oauth_domain=getConfig('oauth_domain');
		$target_url="{$_SERVER['REQUEST_SCHEME']}://{$oauth_domain}/?c=Login&a=register&icode={$icode}";
		header("Location:{$target_url}");
	}
	
	private function genCover($user,$reflush=false){
		$icode=$user['icode'];
		$tg_img='uploads/qrcode/tg_'.$icode.'.jpg';
		if(file_exists(ROOT_PATH.$tg_img)&&!$reflush){
			return $tg_img;
		}
		
        $qrcode=ROOT_PATH.$this->genQrcode($icode);

		$tpl=ROOT_PATH.'public/images/tg.png';
		$image = new \Imagick($tpl);
		$width = $image->getImageWidth();
		$height= $image->getImageHeight();
		//首先进行一个图片绘画
		$newImg = new Imagick($qrcode);
		$qwidth = $newImg->getImageWidth();
		$qheight= $newImg->getImageHeight();
		$newImg->thumbnailImage(460,460);
		//$newImg->newImage($width * $xNum + ($xNum - 1) * $xDistance, $height * $yNum + ($yNum - 1) * $yDistance, '#AAAAAA', 'jpg');
		$image->compositeImage($newImg, Imagick::COMPOSITE_OVER, ($width-$qwidth)/2+18, 244);
		
		$draw = new ImagickDraw();
		$draw->setTextKerning(15); // 设置文字间距
		$draw->setFont(ROOT_PATH.'public/fonts/icode.ttf');
		$draw->setFontWeight(800); // 字体粗体
		$draw->setFillColor('#ffffff'); // 字体颜色
		//$draw->setFontFamily( "Palatino" );
		$draw->setFontSize(55);
		$draw->setGravity( \Imagick::GRAVITY_NORTH );
		//$phone=substr($user['phone'],0,3).'***'.substr($user['phone'],8);
		//$image->annotateImage($draw, 4,435, 0, $phone) ;
		$draw->setFontSize(70);
		$image->annotateImage($draw,-4,420+$qheight, 0, $icode) ;
		//header("Content-Type: image/{$image->getImageFormat()}");
		//echo $image->getImageBlob();
		file_put_contents($tg_img,$image->getImageBlob());
		return $tg_img;
	}
	
	private function genQrcode($icode){
		$icode_name=getRsn();
		$qrcode='uploads/qrcode/'.date('Ym').'/'.$icode_name.'.png';
		if(file_exists($qrcode)){
			//return $qrcode;
		}
        $qrcode_str=$this->getQrcodeUrl($icode);
        if(!is_dir(dirname(ROOT_PATH.$qrcode))){
            mkdir(dirname(ROOT_PATH.$qrcode),0755,true);
        }
		QRcode::png($qrcode_str, ROOT_PATH.$qrcode, 'L', 12, 2);
		return $qrcode;
	}
	
	private function getQrcodeUrl($icode){
		$qr_domain=getConfig('qr_domain');
		if(!$qr_domain){
			//$qr_domain=getConfig('oauth_domain');
			$qr_domain=$_SERVER['HTTP_HOST'];
		}
		$p_data=[
			'icode'=>$icode,
			'time'=>NOW_TIME
		];
		$sign=sysSign($p_data);
		$qrcode_str="{$_SERVER['REQUEST_SCHEME']}://{$qr_domain}/?c=Tg&a=qrcode&icode={$icode}&time={$p_data['time']}&sign={$sign}";
		return $qrcode_str;
	}
	
}

?>