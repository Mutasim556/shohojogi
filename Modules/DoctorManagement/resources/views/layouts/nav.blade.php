<?php
    if(dm_module_config()){
        $module_config = config('doctormanagement');
    }else{
        $module_config = ['valid'=>false];
    }
?>
<?php if ($module_config['valid']==true){
    if (hasPermission([$module_config['permissions']])){
        if (count($module_config['sub_menu'])==false){
        ?>
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav" href="{{ $module_config['route'] }}"
                aria-expanded="false"><i data-feather="unlock"></i><span>
                    <?php echo $module_config['name']?> </span>
            </a>
        </li>
        <?php } else{?>
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="slack"></i>
                <span class="lan-3"><?php echo $module_config['name']?></span>
            </a>
            <ul class="sidebar-submenu">
                <?php
                    foreach($module_config['sub_menu'] as $submenu){
                ?>
                <?php if (hasPermission([$submenu['permissions']])){ ?>
                    <li>
                        <a href="<?php echo $submenu['route'] ?>" class="sidebar-link">
                            <span> <?php echo $submenu['name'] ?> </span>
                        </a>
                    </li>
               <?php }}?>
            </ul>
        </li>
<?php }}}?>
