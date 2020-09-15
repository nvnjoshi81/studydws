<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'error';
$route['translate_uri_dashes'] = FALSE;
$route['appnotes/(:any)/(:any)/(:any)/(:any)/(:num)']="articles/welcome/androidnotes/$1/$2/$3/$4/$5";
$route['pdfnotes/(:any)/(:any)/(:any)/(:any)/(:any)']="articles/welcome/printnotes/$1/$2/$3/$4/$5";

$route['notes/(:any)/(:any)/(:any)/(:any)/(:num)']="articles/welcome/examarticle/$1/$2/$3/$4/$5";
$route['notes/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="articles/welcome/exams/$1/$2/$3/$4/$5/$6";
$route['notes/(:any)/(:num)/(:any)/(:num)']="articles/welcome/exams/$1/$2/$3/$4";
$route['notes/(:any)/(:num)']="articles/welcome/exams/$1/$2";
$route['notes']="articles/welcome/exams";
$route['featured-videos']="videos/welcome/featured";

$route['featured-videos-sub/(:num)/(:num)']="videos/welcome/featuredSubject/$1/$2";
$route['articles/archives/(:num)/(:num)/(:num)']="articles/welcome/archives/$1/$2/$3";
$route['articles/archives/(:num)/(:num)']="articles/welcome/archives/$1/$2";
$route['articles/(:any)/(:num)/(:num)']="articles/welcome/category/$1/$2/$3";
$route['articles/(:any)/(:any)/(:num)']="articles/welcome/article/$1/$2/$3";
$route['articles/(:any)/(:num)']="articles/welcome/category/$1/$2";
$route['articles/(:num)']="articles/welcome/index/$1";
$route['current-affairs/archives/(:num)/(:num)/(:num)']="current-affairs/welcome/archives/$1/$2/$3";
$route['current-affairs/archives/(:num)/(:num)']="current-affairs/welcome/archives/$1/$2";
$route['current-affairs/(:any)/(:num)/(:num)']="current-affairs/welcome/category/$1/$2/$3";
$route['current-affairs/(:any)/(:any)/(:num)']="current-affairs/welcome/article/$1/$2/$3";
$route['current-affairs/(:any)/(:num)']="current-affairs/welcome/category/$1/$2";
$route['current-affairs/(:num)']="current-affairs/welcome/index/$1";

$route['amazing-facts/(:any)/(:num)/(:num)']="amazing-facts/welcome/category/$1/$2/$3";
$route['amazing-facts/(:any)/(:num)']="amazing-facts/welcome/category/$1/$2";
$route['amazing-facts/(:num)']="amazing-facts/welcome/index/$1";

$route['admin/listings/(:num)/(:num)']="admin/listings/index/$1/$2";
$route['admin/listings/(:num)']="admin/listings/index/$1";
$route['admin/history/(:num)/(:num)']="admin/history/index/$1/$2";
$route['admin/history/(:num)']="admin/history/index/$1";

$route['exams/cron_update_packagecnt_byexamid']="exams/welcome/cron_update_packagecnt_byexamid";
$route['exams/cron_update_packagecount']="exams/welcome/cron_update_packagecount";
$route['exams']="exams/welcome/index";
$route['exams/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="exams/welcome/main/$1/$2/$3/$4/$5/$6";
$route['exams/(:any)/(:num)/(:any)/(:num)']="exams/welcome/main/$1/$2/$3/$4";
$route['exams/(:any)/(:num)']="exams/welcome/main/$1/$2";

$route['question-bank/(:any)/(:num)/(:num)']="questionbank/welcome/question/$1/$2/$3";
$route['question-bank/details/(:any)/(:num)']="questionbank/welcome/details/$1/$2";
$route['question-bank/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="questionbank/welcome/index/$1/$2/$3/$4/$5/$6";
$route['question-bank/(:any)/(:num)/(:any)/(:num)']="questionbank/welcome/index/$1/$2/$3/$4";
$route['question-bank/(:any)/(:num)']="questionbank/welcome/index/$1/$2";
$route['question-bank']="questionbank/welcome/index";

$route['question-bank/(:any)/(:any)/(:num)']="questionbank/welcome/details/$2/$3";
$route['question-bank/(:any)/(:any)/(:any)/(:num)']="questionbank/welcome/details/$3/$4";
$route['question-bank/(:any)/(:any)/(:any)/(:any)/(:num)']="questionbank/welcome/details/$4/$5";
$route['appquestion-bank/(:any)/(:any)/(:any)/(:any)/(:num)']="questionbank/welcome/androiddetails/$4/$5";
$route['pdfquestion-bank/(:any)/(:any)/(:any)/(:any)/(:any)']="questionbank/welcome/printdetails/$4/$5";
$route['videos/playlist/(:any)/(:num)']="videos/welcome/playlist/$1/$2";
$route['videos/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="videos/welcome/index/$1/$2/$3/$4/$5/$6";
$route['videos/(:any)/(:num)/(:any)/(:num)']="videos/welcome/index/$1/$2/$3/$4";
$route['videos/(:any)/(:num)']="videos/welcome/index/$1/$2";
$route['videos']="videos/welcome/index";
$route['videos/play/(:any)/(:num)']="videos/welcome/play/$1/$2";

$route['videos/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)']="videos/welcome/play/$5/$6";
$route['videos/(:any)/(:any)/(:num)']="videos/welcome/playlist/$2/$3";
$route['videos/(:any)/(:any)/(:any)/(:num)']="videos/welcome/playlist/$3/$4";
$route['videos/(:any)/(:any)/(:any)/(:any)/(:num)']="videos/welcome/playlist/$4/$5";
$route['sample-papers/(:any)/(:num)/(:num)']="samplepapers/welcome/question/$1/$2/$3";
$route['sample-papers/details/(:any)/(:num)']="samplepapers/welcome/details/$1/$2";
$route['sample-papers/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="samplepapers/welcome/index/$1/$2/$3/$4/$5/$6";
$route['sample-papers/(:any)/(:num)/(:any)/(:num)']="samplepapers/welcome/index/$1/$2/$3/$4";
$route['sample-papers/(:any)/(:num)']="samplepapers/welcome/index/$1/$2";
$route['sample-papers']="samplepapers/welcome/index";

// sample-papers/exam-name/samplepaper-name/samplpaper-id
$route['sample-papers/(:any)/(:any)/(:num)']="samplepapers/welcome/details/$2/$3";
// sample-papers/exam-name/subject-name/samplepaper-name/samplpaper-id
$route['sample-papers/(:any)/(:any)/(:any)/(:num)']="samplepapers/welcome/details/$3/$4";
$route['appsample-papers/(:any)/(:any)/(:any)/(:num)']="samplepapers/welcome/androiddetails/$3/$4";
$route['appsample-papers/(:any)/(:any)/(:num)']="samplepapers/welcome/androiddetails/$2/$3";
//sample-papers/exam-name/subject-name/chapter-name/samplepaper-name/samplpaper-id
$route['sample-papers/(:any)/(:any)/(:any)/(:any)/(:num)']="samplepapers/welcome/details/$4/$5";
$route['pdfsample-papers/(:any)/(:any)/(:any)/(:any)/(:any)']="samplepapers/welcome/printdetails/$4/$5";
$route['solved-papers/(:any)/(:num)/(:num)']="solved-papers/welcome/question/$1/$2/$3";
$route['solved-papers/details/(:any)/(:num)']="solved-papers/welcome/details/$1/$2";
$route['solved-papers/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="solved-papers/welcome/index/$1/$2/$3/$4/$5/$6";
$route['solved-papers/(:any)/(:num)/(:any)/(:num)']="solved-papers/welcome/index/$1/$2/$3/$4";
$route['solved-papers/(:any)/(:num)']="solved-papers/welcome/index/$1/$2";
$route['solved-papers']="solved-papers/welcome/index";

// sample-papers/exam-name/samplepaper-name/samplpaper-id
$route['solved-papers/(:any)/(:any)/(:num)']="solved-papers/welcome/details/$2/$3";
// sample-papers/exam-name/subject-name/samplepaper-name/samplpaper-id
$route['solved-papers/(:any)/(:any)/(:any)/(:num)']="solved-papers/welcome/details/$3/$4";
// sample-papers/exam-name/subject-name/chapter-name/samplepaper-name/samplpaper-id
$route['solved-papers/(:any)/(:any)/(:any)/(:any)/(:num)']="solved-papers/welcome/details/$4/$5";
$route['appsolved-papers/(:any)/(:any)/(:any)/(:any)/(:num)']="solved-papers/welcome/androiddetails/$4/$5";

$route['pdfsolved-papers/(:any)/(:any)/(:any)/(:any)/(:any)']="solved-papers/welcome/printdetails/$4/$5";
$route['online-test/results/']="onlinetest/welcome/results";
$route['online-test/result/(:num)']="onlinetest/welcome/test_result/$1";
$route['online-test/attempts/(:num)']="onlinetest/welcome/attempt_history/$1";
$route['online-test/attempts/(:num)/(:any)']="onlinetest/welcome/attempt_history/$1/$2";
/*For app Attampt history*/

$route['online-test/appattempts/(:num)']="onlinetest/welcome/androidattempt_history/$1";
$route['online-test/appattempts/(:num)/(:any)']="onlinetest/welcome/androidattempt_history/$1/$2";

/*For App*/

$route['online-test/details/(:num)']="onlinetest/welcome/details/$1";
$route['online-test/details/(:num)']="onlinetest/welcome/details/$1";
$route['online-test/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="onlinetest/welcome/index/$1/$2/$3/$4/$5/$6";
$route['online-test/(:any)/(:num)/(:any)/(:num)']="onlinetest/welcome/index/$1/$2/$3/$4";
$route['online-test/(:any)/(:num)']="onlinetest/welcome/index/$1/$2";
//For pagination
$route['online-test/exam/(:num)/(:num)']="onlinetest/welcome/exampaper/$1/$2";
$route['online-test/exam/(:num)/subject/(:num)/(:num)']="onlinetest/welcome/subjectpaper/$1/$2/$3";
$route['online-test']="onlinetest/welcome/index";
$route['online-test/question_detail/(:num)/(:num)']="onlinetest/welcome/question_detail/$1/$2";
// online-test/exam-name/online-test-name/online-test-id
$route['online-test/(:any)/(:any)/(:num)']="onlinetest/welcome/details/$2/$3";
// online-test/exam-name/subject-name/online-test-name/online-test-id
$route['online-test/(:any)/(:any)/(:any)/(:num)']="onlinetest/welcome/details/$3/$4";
// online-test/exam-name/subject-name/chapter-name/online-test-name/online-test-id
$route['online-test/(:any)/(:any)/(:any)/(:any)/(:num)']="onlinetest/welcome/start_exam/$1/$2/$3/$4/$5";
$route['online-test-result/(:any)/(:num)']="onlinetest/welcome/all_result/$1/$2";
$route['apponline-test-result/(:any)/(:num)']="onlinetest/welcome/androidall_result/$1/$2";
$route['online-test/start/(:any)']="onlinetest/start/index/$1";
$route['online-test/start']="onlinetest/start/index";
$route['apponline-test/androidusernotfound']="onlinetest/start/androidusernotfound";
$route['apponline-test/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)/(:any)']="onlinetest/start/androidindex/$1/$2/$3/$4/$5/$6/$7/$8";
$route['apponline-test/qinfo/(:num)']="onlinetest/start/appquesinfo/$1";
$route['apponline-test/ansinfo/(:num)']="onlinetest/start/appansinfo/$1";
$route['apponline-test/app-paper/qid/(:num)']="onlinetest/start/app_paper/$1";
$route['apponline-test/result/(:num)']="onlinetest/start/androidtest_result/$1";
$route['apponline-test/userresult/(:any)/(:num)']="onlinetest/start/androiduseertest_result/$1/$2";
//5th parm for customer id encripted form
$route['apponline-test/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)']="onlinetest/welcome/androidstart_exam/$1/$2/$3/$4/$5/$6";
$route['apponline-test/getresult/(:any)']='onlinetest/welcome/androidotpdf/$1';
$route['solved-papers/details']="solved-papers/welcome/details";
$route['study-packages/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="study-material/welcome/index/$1/$2/$3/$4/$5/$6";
$route['study-packages/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)']="study-material/welcome/show/$5/$6";
$route['study-packages/details/(:any)/(:num)']="study-material/welcome/details/$1/$2";
$route['study-packages/(:any)/(:num)/(:any)/(:num)']="study-material/welcome/index/$1/$2/$3/$4";
$route['study-packages/(:any)/(:num)']="study-material/welcome/index/$1/$2";
$route['study-packages']="study-material/welcome/index";
$route['study-packages/show/(:any)/(:num)']="study-material/welcome/show/$1/$2";
$route['study-packages/(:any)/(:any)/(:num)']="study-material/welcome/details/$2/$3";
$route['study-packages/(:any)/(:any)/(:any)/(:num)']="study-material/welcome/details/$3/$4";
$route['study-packages/(:any)/(:any)/(:any)/(:any)/(:num)']="study-material/welcome/details/$4/$5";
$route['study-packages/(:any)/(:any)/(:num)']="study-material/welcome/showanswer/$1/$2/$3";

$route['books/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)']="books/welcome/show/$5/$6";
$route['books/details/(:any)/(:num)']="books/welcome/details/$1/$2";
$route['books/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="books/welcome/index/$1/$2/$3/$4/$5/$6";

$route['books/(:any)/(:num)/(:any)/(:num)']="books/welcome/index/$1/$2/$3/$4";
$route['books/(:any)/(:num)']="books/welcome/index/$1/$2";
$route['books']="books/welcome/index";
$route['books/show/(:any)/(:num)']="books/welcome/show/$1/$2";

$route['books/(:any)/(:any)/(:num)']="books/welcome/details/$2/$3";
$route['books/(:any)/(:any)/(:any)/(:num)']="books/welcome/details/$3/$4";
$route['books/(:any)/(:any)/(:any)/(:any)/(:num)']="books/welcome/details/$4/$5";
$route['user']='customer/welcome';

$route['user/library']='customer/welcome/library';
$route['user/my_videos']='customer/welcome/myvideos';
$route['user/my_studypackages']='customer/welcome/mystudypackages';
$route['user/my_testseries']='customer/welcome/mytestseries';
$route['user/tests/(:any)']='customer/welcome/tests/$1';
$route['user/orderdetails/(:any)']='customer/welcome/orderdetails/$1';
$route['user/address/(:num)']='customer/welcome/address/$1';
$route['user/setdefault/(:num)']='customer/welcome/setdefault/$1';
$route['user/(:any)']='customer/welcome/$1';
$route['user/orders/(:num)']='customer/welcome/orders/$1';
$route['user/recommendations/(:num)']='customer/welcome/recommendations/$1';
$route['customer/updatecustomer']='customer/welcome/updatecustomer';
$route['customer/myaccount']='customer/welcome/myaccount';

$route['ncert-solution/download/(:any)']="ncert-solution/welcome/downloadPDF/$1";
$route['ncert-solution/(:any)/(:num)/(:num)']="ncert-solution/welcome/question/$1/$2/$3";
$route['ncert-solution/details/(:any)/(:num)']="ncert-solution/welcome/details/$1/$2";
$route['ncert-solution/(:any)/(:num)/(:any)/(:num)/(:any)/(:num)']="ncert-solution/welcome/index/$1/$2/$3/$4/$5/$6";
$route['ncert-solution/(:any)/(:num)/(:any)/(:num)']="ncert-solution/welcome/index/$1/$2/$3/$4";
$route['ncert-solution/(:any)/(:num)']="ncert-solution/welcome/index/$1/$2";
$route['ncert-solution']="ncert-solution/welcome/index";
$route['ncert-solution/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)']="ncert-solution/welcome/show/$5/$6";
$route['ncert-solution/(:any)/(:any)/(:num)']="ncert-solution/welcome/details/$2/$3";
$route['ncert-solution/(:any)/(:any)/(:any)/(:num)']="ncert-solution/welcome/details/$3/$4";
$route['ncert-solution/(:any)/(:any)/(:any)/(:any)/(:num)']="ncert-solution/welcome/details/$4/$5";
$route['appncert-solution/(:any)/(:any)/(:any)/(:any)/(:num)']="ncert-solution/welcome/androiddetails/$4/$5";
$route['account/verify/(:any)']='common/verify/$1';
$route['payment_terms']='common/payment_terms';
$route['about']='common/about';
$route['jobs']='common/jobs';
$route['faq']='common/faq';
$route['howtouse']='common/meating';
$route['sitemap']='common/sitemap';
$route['franchise_welcome']='common/franchise_regi';
$route['franchise']='common/franchise';
$route['codetest']='common/codetest';
$route['refund-policy']='common/refund';
$route['why-studyadda']='common/whystudyadda';
$route['test']='common/test';
/*MEATING*/
$route['meating']='meating/welcome/index';
$route['media']='media/welcome/index';
$route['media/notify']='media/welcome/notify';
$route['media/notify/(:any)/(:any)/(:any)']='media/welcome/notify/$1/$2/$3';
$route['appmedia/notify']='media/welcome/androidnotify';
$route['appmedia/notify/(:any)/(:any)/(:any)']='media/welcome/androidnotify/$1/$2/$3';
$route['contact-us']='common/contact';
$route['privacy-policy']='common/privacy';
//$route['lalitsardana']='common/lalitsardana';
$route['(?i)lalit-sardana-sir']='common/lalitsardana';
$route['(?i)purchase-courses']='common/allproduct';
$route['(?i)purchase-courses/(:any)/(:num)']='common/allproduct/$1/$2';
$route['search/(:any)/(:any)']='search/index/$1/$2';
$route['search/(:any)/(:any)/(:num)']='search/index/$1/$2/$3';
$route['free-videos/(:any)/(:num)']='videos/welcome/freevideos/$1/$2';
$route['study-packages/download/(:any)']='common/download/$1';
$route['online-test/getresult/(:any)']='common/download_olsolution/$1';
$route['free-videos']='videos/welcome/freevideos';
$route['customer/tests/(:any)']='customer/welcome/tests/$1';
$route['customer/orderdetails/(:any)']='customer/welcome/orderdetails/$1';
$route['customer/address/(:num)']='customer/welcome/address/$1';
$route['customer/setdefault/(:num)']='customer/welcome/setdefault/$1';
$route['customer/(:any)']='customer/welcome/$1';