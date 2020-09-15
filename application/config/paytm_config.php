<?php if(!defined('BASEPATH')) die('No direct access allowed!');

$mode='TEST';
$PAYTM_DOMAIN = "pguat.paytm.com";
if ($mode == 'PROD') {
	$PAYTM_DOMAIN = 'secure.paytm.in';
}
$config['paytm'] = array(
							'PAYTM_ENVIRONMENT'  => 'TEST',
                            'PAYTM_DOMAIN'  => $PAYTM_DOMAIN,
                            'PAYTM_MERCHANT_KEY'  => '',
                            'PAYTM_MERCHANT_MID'    => '',
                            'PAYTM_MERCHANT_WEBSITE'    => '',
                            'PAYTM_REFUND_URL'    => 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND',
                            'PAYTM_STATUS_QUERY_URL'    => 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/TXNSTATUS',
                            'PAYTM_TXN_URL'    => 'https://'.$PAYTM_DOMAIN.'/oltp-web/processTransaction'
                        );






