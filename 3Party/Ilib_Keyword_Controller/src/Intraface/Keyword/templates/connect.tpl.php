<h1><?php e(__('add keywords to') . ' ' . $object->get('name')); ?></h1>

<?php echo $keyword->error->view(); ?>

<form action="<?php e(url('./')); ?>" method="post">
    <?php if (is_array($keywords) AND count($keywords) > 0): ?>
    <fieldset>
        <legend><?php e(__('choose keywords')); ?></legend>
        <input type="hidden" name="<?php echo $id_name; ?>" value="<?php echo $object->get('id'); ?>" />
        <?php
            $i = 0;
            foreach ($keywords AS $k) {
                print '<input type="checkbox" name="keyword[]" id="k'.$k['id'].'" value="'.$k['id'].'"';
                if (in_array($k['id'], $checked)) {
                    print ' checked="checked" ';
                }
                print ' />';
                print ' <label for="k'.$k["id"].'">' . htmlentities($k['keyword']) . ' (#'.$k["id"].')</a></label> - <a href="'.$this->url(null, array($id_name => $object->get('id'), 'delete' => $k["id"])).'" class="confirm">' .__('delete', 'common'). '</a><br />'. "\n";
        }
        ?>
    </fieldset>
        <div style="clear: both; margin-top: 1em; width:100%;">
            <input type="submit" value="<?php e(__('choose')); ?>" name="submit" class="save" /> <input type="submit" value="<?php e(__('choose and close')); ?>" name="close" class="save" />
        </div>

    <?php endif; ?>
    <fieldset>
        <legend><?php e(__('create keyword')); ?></legend>
        <p><?php e(__('separate keywords by comma')); ?></samp></p>
        <input type="hidden" name="<?php echo $id_name; ?>" value="<?php echo $object->get('id'); ?>" />
        <label for="keyword"><?php e(__('keywords')); ?></label>
        <input type="text" name="keywords" id="keyword" value="<?php // echo $keyword_string; ?>" />
        <input type="submit" value="<?php e(__('save', 'common')); ?>" name="submit" name="close" />
    </fieldset>
</form>