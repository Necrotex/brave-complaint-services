<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=URL::route('home')?>">BRAVE Complaint Service</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=URL::route('home')?>">Home</a>
                </li>
                <?php if(!Auth::guest()): ?>
                <li>
                    <?php if(Auth::user()->isReviewer()): ?>
                        <a href="<?=URL::route('overview')?>">Complaints</a>
                    <?php else: ?>
                        <a href="<?=URL::route('overview')?>">My Complaints</a>
                    <?php endif; ?>
                </li>
                <?php endif; ?>
            </ul>

            <ul class="nav navbar-nav pull-right">

                <?php
                if(!Auth::guest())
                {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <strong><?=Auth::user()->character_name?></strong> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=URL::route('logout')?>">Logout</a></li>
                        </ul>
                    </li>
                <?php
                }
                else
                {
                    ?>
                    <li <?php if(Request::is('login')){?> class="active"<?php }?>><a href="<?=URL::route('login')?>">Login</a></li>
                <?php
                }
                ?>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>