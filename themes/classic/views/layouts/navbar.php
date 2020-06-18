<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Default App Metro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th-large"></i> Product <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">ประเภทสินค้า</a></li>
                <li><a href="#">สินค้า</a></li>
                <li class="divider"></li>
                <li><a href="#">หน่วยนับ</a></li>
              </ul>
            </li>
            <li><a href="#"><i class="glyphicon glyphicon-tower"></i> Supplier</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-download-alt"></i> Buyin<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">เปิดบิลซื้อเข้า</a></li>
                <li><a href="#">ข้อมูลซื้อเข้า</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-usd"></i> Sales<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">เปิดบิลขาย</a></li>
                <li><a href="#">ข้อมูลขาย</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th"></i> Stock<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">แก้ไขข้อมูลสต็อก</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-file"></i> Report<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Stock Card</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Setting<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">System</li>
                <li><a href="#">ตั้งค่าระบบ</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">User & Permission</li>
                <li><a href="#">Group & Permission</a></li>
                <li><a href="#">User</a></li>
              </ul>
            </li>
            <?php if(!empty(Yii::app()->request->cookies['cookie_user_id']->value)){ ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> [<?php echo Yii::app()->request->cookies['cookie_user_id']->value ?>] <?php echo Yii::app()->request->cookies['cookie_user_prosonal']->value ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#">Profile</a></li> -->
                <li><a href="<?php echo $this->createUrl("/sign/out"); ?>">Signout</a></li>
              </ul>
            </li>
            <?php }else{?>
            <li><a href="<?php echo $this->createUrl("/sign/in"); ?>"><i class="glyphicon glyphicon-log-in"></i> SignIn</a></li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>