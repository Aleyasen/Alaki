<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<pre style =" font-family: tahoma">

<center class="lead">Facebook Group Detection Study Terms and Conditions</center>
Facebook Group Detection Study needs to collect your Facebook friends list and their relationships to use in a research study conducting by University of Illinois at Urbana-Champaign. Here, we describe the terms and conditions of our group detection application which complies with Facebook terms and conditions. Please read the following statements and if you agree with these terms, check the agree box and login with the application.

<strong style="color: #3A9BD6;">Registration and Account Security</strong>
First, you will login to the Group Detection Application that we can make the group structures of your Facebook friends. We will NOT save any information about your account secure information such as your password since you will be redirected to a Facebook page to login and we do not have access to such information then. So, your account information will be secured by Facebook.

<strong style="color: #3A9BD6;">Information Collection</strong>
We will collect your Facebook friends’ list and some of their public information such as the age, location and education in order to apply some group detection methods and find your friends’ different group structures. NO private information will be collected by our application. When you login with the Group Detection Application, the description of all the information that we need to collect will be shown to get your approval. You may at any time request that we delete all data in our study pertaining to you.

<strong style="color: #3A9BD6;">Privacy Protection</strong>
In the second phase of study, you will login to the application again to see three different group structures of your Facebook friends which is made by our group detection study. We will not have access to any private information of you or your friends. Therefore, there will be no security risk for you and your friends too. To protect you and your friends’ privacy, the names of you and your friends will be anonymized using codes such as participant1, friend1, friend2, and friend3. 

<strong style="color: #3A9BD6;">Sharing the Collected Information</strong>
We may share the information with the researchers listed on the consent form for the Facebook Group Detection study which is given to you in the start of the study. If we want to share the data collected in this study with others, we will anonymized the data completely. If we want to present the final results of the study in any public conference, journal or talk, all the names will be presented in the anonymized format and the pictures will be blurred to protect your privacy.

<strong style="color: #3A9BD6;">Contact us</strong>
If you have any questions or comments about this application, please contact us at
eslamim2@illinois.edu or kkarahal@illinois.edu
</pre>

<br/><br/>
<div>
<?php echo CHtml::checkBox('agree', false);?>
  I read terms and conditions and agree with them.
</div>
<br/><br/>
<?php echo CHtml::button('Continue', array('class' => 'btn', 'submit' => array('frontend/intro'))); ?>