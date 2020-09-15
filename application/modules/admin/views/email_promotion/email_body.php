<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>A Simple Responsive HTML Email</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                Hello <?php echo $studentname; ?>!,
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Now get All videos and studymaterial at 40-50% discount.Please login to <a href="www.studyadda.com/login"><?php echo$website_name; ?></a> .Also <?php echo $website_name; ?> offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance examsStudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.<br>
                                    Only portal providing FREE study material, Sample Papers, Solved Papers, Question bank, Online Tests, Blogs, News of more than 50 engineering, medical & management exams conducted in India.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>