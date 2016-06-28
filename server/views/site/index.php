<?php
?>
<style type="text/css">
    .landing-page .btn-default{
        font-size: 14px;
    }
</style>
<div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1>超好用的<br/>
                        团队即时通讯工具<br/>
                        消息云端存储，永不丢失<br/>
                        </h1>
                    <p>简洁高效的用户体验，一切都是那么的自然。</p>
                    <p>
                        <a class="btn btn-lg btn-primary" href="<?= \yii\helpers\Url::to(['site/create-domain']); ?>" role="button">创建账户</a>
                        <a class="btn btn-lg btn-default" href="http://<?= 'demo1' . Yii::$app->params['base_client'] ?>" role="button">测试账号</a>
                    </p>
                </div>
                <div class="carousel-image wow zoomIn">
                    <img src="/img/landing/laptop.png" alt="laptop"/>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank">
                    <h1>敏捷开发的管理工具 <br/> 显著的提升团队工作效率.</h1>
                    <p>任务分发，错误追踪，燃尽图，项目Wiki，等等</p>
                    <a class="btn btn-lg btn-primary" href="<?= \yii\helpers\Url::to(['site/create-domain']); ?>" role="button">创建账户</a>
                    <a class="btn btn-lg btn-default" href="http://<?= 'demo1' . Yii::$app->params['base_client'] ?>" role="button">测试账号</a>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
    </div>
    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<section id="features" class="container services">
    <div class="row">
        <div class="col-sm-3">
            <h2>团队即时通讯</h2>
            <p>
                团队成员的一对一聊天，群组聊天，可以发送文件，图片以及拥有优美格式的代码片段。
                并且这一切都是保存在云端的，只要有网络就可以查看到，再也不用担心多终端的消息或附件丢失问题。
               </p>
            <p><a class="navy-link" href="#" role="button">详细 &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>敏捷开发管理</h2>
            <p>拥有项目的管理，里程碑的管理，清晰的燃尽图，方便好用的敏捷面板。
               专门为敏捷开发量身打造的管理工具。显著的提高团队开发效率。</p>
            <p><a class="navy-link" href="#" role="button">详细 &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>客服系统</h2>
            <p>提供客服插件，在网页中插入一行代码，这个网页就拥有一个客服系统，客服人员可以方便的和客户沟通。</p>
            <p><a class="navy-link" href="#" role="button">详细 &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>多终端支持</h2>
            <p>拥有网页版, IOS, Android版， 随时随地沟通交流和处理任务。</p>
            <p><a class="navy-link" href="#" role="button">详细 &raquo;</a></p>
        </div>
    </div>
</section>
<section  class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>功能介绍<br/> <span class="navy"> 即时沟通工具</span> </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div>
                <i class="fa fa-mobile features-icon"></i>
                <h2>跨平台</h2>
                <p>不管你是Windows, Mac, Linux只要你打开浏览器就可以无障碍的使用，手机上也有IOS,Android的App 下载。 </p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-bar-chart features-icon"></i>
                <h2>聊天消息同步</h2>
                <p>无论你用什么客户端登录，都可以查看到完整的聊天记录。</p>
            </div>
        </div>
        <div class="col-md-6 text-center  wow zoomIn">
            <img src="/img/landing/perspective.png" alt="dashboard" class="img-responsive">
        </div>
        <div class="col-md-3 text-center wow fadeInRight">
            <div>
                <i class="fa fa-envelope features-icon"></i>
                <h2>支持文件和代码的发送</h2>
                <p>
<!--                    开发的人都有这种场景，通过QQ发送一段代码，结果代码完全没有了格式，中间还参差着几个表情。-->
                    可以发送各种文件，也支持同步的。
                    还有发送代码片段的功能，发送的代码片段，格式优美，并且关键字高亮。是码农协作的好工具。
                </p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-google features-icon"></i>
                <h2>群组聊天</h2>
                <p>方便快捷的群组聊天，让大家一起讨论，脑洞大开。</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>方便的个人面板</h1>
            <p>我的任务，我加入的项目，待办事项等等。</p>
        </div>
    </div>
    <div class="row features-block">
        <div class="col-lg-6 features-text wow fadeInLeft">
            <p>
                一目了然的查看到分配给我的任务，我的待办事项，项目内的公开资料，团队内部分享的文章。
<!--            <a href="" class="btn btn-primary">Learn more</a>-->
        </div>
        <div class="col-lg-6 text-right wow fadeInRight">
            <img src="/img/landing/dashboard.png" alt="dashboard" class="img-responsive pull-right">
        </div>
    </div>
</section>
<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>项目管理</h1>
                <p>项目的创建，里程碑的创建，任务的分发，已完成任务的索引. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-3 features-text wow fadeInLeft">
                <h2>项目的管理 </h2>
                <p>项目管理，项目成员的管理，项目内分享文章，资料。</p>
            </div>
            <div class="col-lg-6 text-right m-t-n-lg wow zoomIn">
                <img src="/img/landing/iphone.jpg" class="img-responsive" alt="dashboard">
            </div>
            <div class="col-lg-3 features-text text-right wow fadeInRight">
                <h2>里程碑的管理 </h2>
                <p>为项目设置分段式里程碑，阶段性的完成目标，里程碑的进度控制，任务和工时的燃尽图显示，更好的掌握开发进度。</p>
            </div>
        </div>
    </div>

</section>
<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>更多的实用功能</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <h2>项目群组聊天 </h2>
                <i class="fa fa-bolt big-icon pull-right"></i>
                <p>项目创建之后，自动生成一个所有项目成员的聊天组，方便项目成员之间的交流。</p>
            </div>
            <div class="col-lg-5 features-text">
                <h2>实时通知系统 </h2>
                <i class="fa fa-bar-chart big-icon pull-right"></i>
                <p>无论是项目的改变，任务单的分配，都有实时推送的通知，不会因此错过重要的改变.</p>
            </div>
        </div>
<?php /*
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <h2>Perfectly designed </h2>
                <i class="fa fa-clock-o big-icon pull-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
            <div class="col-lg-5 features-text">
                <h2>Perfectly designed </h2>
                <i class="fa fa-users big-icon pull-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
        </div>
 */
?>
    </div>

</section>
<section id="team" class="gray-section team">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>我们的团队</h1>
            </div>
        </div>
        <div class="row">
<?php /*
            <div class="col-sm-4 wow fadeInLeft">
                <div class="team-member">
                    <img src="img/landing/avatar3.jpg" class="img-responsive img-circle img-small" alt="">
                    <h4><span class="navy">Amelia</span> Smith</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus. </p>
                    <ul class="list-inline social-icon">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
 */ ?>
            <div class="col-sm-4 col-sm-offset-4">
                <div class="team-member wow zoomIn">
                    <img src="https://avatars3.githubusercontent.com/u/4466538?v=3&s=150" class="img-responsive img-circle" alt="">
                    <h4><span class="navy">Drake</span> Wang</h4>
                    <p>目前只有我一人，全栈工程师</p>
                    <ul class="list-inline social-icon">
                        <li><a target="_blank" href="http://weibo.com/warerwang"><i class="fa fa-weibo"></i></a>
                        </li>
                        <li><a target="_blank" href="https://github.com/warerwang"><i class="fa fa-github"></i></a>
                        </li>
                        <li><a target="_blank" href="http://blog.warphp.com"><i class="fa fa-home"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
<?php /*
            <div class="col-sm-4 wow fadeInRight">
                <div class="team-member">
                    <img src="img/landing/avatar2.jpg" class="img-responsive img-circle img-small" alt="">
                    <h4><span class="navy">Peter</span> Johnson</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>
                    <ul class="list-inline social-icon">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
 */ ?>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p>希望有更多有能力又热情的的工程师加入我们。</p>
            </div>
        </div>
    </div>
</section>
<section class="timeline gray-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>时间线</h1>
            </div>
        </div>
        <div class="row features-block">

            <div class="col-lg-12">
                <div id="vertical-timeline" class="vertical-container light-timeline center-orientation">
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-briefcase"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>正在继续</h2>
                            <p>
                                上线后，开始了正常的双周迭代。期待下一个增长点。
                            </p>
<!--                            <span class="vertical-date"> Today <br/> <small>Dec 24</small> </span>-->
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>第一个版本的发布</h2>
                            <p>经历了2周的编码（每天只有下班后才有时间），第一个版本上线了，虽然上线一天内就宕机了，但是这并影响他已经上线了。单聊，群聊，发送附件，发送代码片段都已经完成。</p>
                            <span class="vertical-date"> 周二 <br/> <small>15年 八月十四日</small> </span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>项目开始</h2>
                            <p>一个无聊的晚上，终于无法忍受了难用的项目管理工具，心想为什么我不能自己做一个呢？于是开始这个项目。</p>
                            <span class="vertical-date"> 周五 <br/> <small>15年 八月十四日</small> </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<?php /*
<section id="testimonials" class="navy-section testimonials" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center wow zoomIn">
                <i class="fa fa-comment big-icon"></i>
                <h1>
                    What our users say
                </h1>
                <div class="testimonials-text">
                    <i>"Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."</i>
                </div>
                <small>
                    <strong>12.02.2014 - Andy Smith</strong>
                </small>
            </div>
        </div>
    </div>

</section>
<section class="comments gray-section" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>What our partners say</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="img/landing/avatar3.jpg">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="img/landing/avatar1.jpg">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="img/landing/avatar2.jpg">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>



        </div>
    </div>

</section>
 */
?>
<section id="pricing" class="pricing">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>价格服务</h1>
                <p>不同价格以及不同版本之间的区别.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled">
                    <li class="pricing-title">
                        免费版
                    </li>
                    <li class="pricing-desc">
                        人数限制为20人，免费储存附件大小为300M.
                    </li>
                    <li class="pricing-price">
                        <span>免费</span>
                    </li>
                    <li>
                        单聊，群聊
                    </li>
                    <li>
                        项目管理
                    </li>
                    <li>
                        任务单管理
                    </li>
                    <li>
                        提供邮件支持
                    </li>
                    <li>
                        <a class="btn btn-primary btn-xs" href="<?= \yii\helpers\Url::to(['site/create-domain']); ?>" role="button">创建账户</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled selected">
                    <li class="pricing-title">
                        标准版
                    </li>
                    <li class="pricing-desc">
                        人数限制为100人，免费储存附件大小为5G.
                    </li>
                    <li class="pricing-price">
                        <span>99元</span> / 月
                    </li>
                    <li>
                        单聊，群聊
                    </li>
                    <li>
                        项目管理
                    </li>
                    <li>
                        任务单管理
                    </li>
                    <li>
                        提供邮件支持, QQ , 电话支持.
                    </li>
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs" href="<?= \yii\helpers\Url::to(['site/create-domain']); ?>" role="button">创建账户</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled">
                    <li class="pricing-title">
                        旗舰版
                    </li>
                    <li class="pricing-desc">
                        人数限制为100人，免费储存附件大小为1T. 另外支持安装到你们自己的服务器中。
                    </li>
                    <li class="pricing-price">
                        <span>499元</span> / 月
                    </li>
                    <li>
                        单聊，群聊
                    </li>
                    <li>
                        项目管理
                    </li>
                    <li>
                        任务单管理
                    </li>
                    <li>
                        提供邮件支持, QQ , 电话支持.（7×24小时支持）
                    </li>
                    <li>
                        <a class="btn btn-primary btn-xs" href="<?= \yii\helpers\Url::to(['site/create-domain']); ?>" role="button">创建账户</a>
                    </li>
                </ul>
            </div>
        </div>
<!--        <div class="row m-t-lg">-->
<!--            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg">-->
<!--                <p></p>-->
<!--            </div>-->
<!--        </div>-->
    </div>

</section>
<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>联系我</h1>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-3 col-lg-offset-3">
                <address>
                    QQ: 373299607<br/>
                    Email: Drake@warphp.com<br/>
                </address>
            </div>
            <div class="col-lg-4">
                <p class="text-color">
                    这个家伙很懒，什么都没有留下。
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:drake@warphp.com" class="btn btn-primary">发送邮件</a>
                <p class="m-t-sm">
                    或者关注我的社交账号
                </p>
                <ul class="list-inline social-icon">
                    <li><a target="_blank" href="http://weibo.com/warerwang"><i class="fa fa-weibo"></i></a>
                    </li>
                    <li><a target="_blank" href="https://github.com/warerwang"><i class="fa fa-github"></i></a>
                    </li>
                    <li><a target="_blank" href="http://blog.warphp.com"><i class="fa fa-home"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p>
                    <strong>&copy; <?= date('Y'); ?> WarPhp</strong><br/>
                    目前这个项目只是我出于兴趣的个人项目
                </p>
            </div>
        </div>
    </div>
</section>