<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="row">
        <div class="span9">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="span3">
            <div id="sidebar">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => 'Operations',
                    'titleCssClass' => 'alert alert-info',
                    'htmlOptions' => array('role' => 'alert')
                ));
                $this->widget('bootstrap.widgets.TbMenu', array(
                    'items' => $this->menu
                ));
                $this->endWidget();

                $this->widget(
                    'TagCloud', array(
                        'maxTags' => Yii::app()->params['tagCloudCount'],
                        'titleCssClass' => 'alert alert-info',
                        'htmlOptions' => array('role' => 'alert')
                    ));

                $this->widget(
                    'RecentComments', array(
                        'maxComments' => Yii::app()->params['maxComments'],
                        'titleCssClass' => 'alert alert-info',
                        'htmlOptions' => array('role' => 'alert')
                    ));

                $this->widget(
                    'ArchivedPostPortlet', array(
                        'limit' => 10,
                        'titleCssClass' => 'alert alert-info',
                        'htmlOptions' => array('role' => 'alert')
                    )
                );

                ?>
            </div>
            <!-- sidebar -->
        </div>
    </div>
<?php $this->endContent(); ?>