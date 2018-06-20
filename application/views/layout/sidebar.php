 <div class="sidebar-menu">

        <div class="sidebar-menu-inner">
            
            <header class="logo-env">

                <!-- logo -->
                <div class="logo">
                    <a href="index.html">
                        <!--<img src="<?php echo base_url();?>/assets/images/logo@2x.png" width="120" alt="" />-->
                    </a>
                </div>

                <!-- logo collapse icon -->
                <div class="sidebar-collapse">
                    <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

                                
                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs">
                    <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

            </header>
            
                                    
            <ul id="main-menu" class="main-menu">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

                <?php
                /*echo "<pre>";
                print_r($menuSildebar);
                echo "</pre>";*/

                if(count($menuSildebar)>0){
                    $opened ="";
                    foreach ($menuSildebar as $key => $value) {
                        $opened ='';
                        if($value['nombre'] ==$directorio){
                           $opened ="opened active";
                        }
                        ?>
                        <li class="<?php  echo $opened;?>">
                            <a href="#">
                                <i class="entypo-gauge"></i>
                                <span class="title"><?php echo $value['nombre'];?></span>
                            </a>
                            <ul>
                                <?php foreach ($value['subMenu'] as $sub){
                                    $active ='';
                                     if($SubDirectorio == $sub->NOMBRE){
                                        $active ="active";
                                    }
                                ?>
                                <li class="<?php echo $active;?>">
                                    <a href="<?php echo base_url().$sub->URL;?>">
                                        <i class="entypo-layout"></i>
                                        <span class="title"><?php echo $sub->NOMBRE;?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                       <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<div class="main-content">