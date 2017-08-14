<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"/home/wwwroot/heizi/public/../app/admin/view/widget/td_switch.html";i:1502615866;}*/ ?>
<td>
    <input type="checkbox" name="show" lay-skin="switch" lay-text="<?php echo $data['if']; ?>|<?php echo $data['else']; ?>"
           lay-filter="isShow"  data-field = "<?php echo $data['title']; ?>" data-status = "<?php echo $vo[$data['title']]; ?>"
           class="onchage<?php echo $vo['id']; ?>" value ="<?php echo $vo['id']; ?>"  data-tab="<?php echo $data['table']; ?>" data-url ="<?php echo url('Change_status'); ?>"
           <?php
                if($vo[$data['title']] == 1){
           ?>
                checked
            <?php
                }
            ?>
           data-tab="<?php echo $data['table']; ?>" data-url ="<?php echo url('Change_status'); ?>"
    >
</td>