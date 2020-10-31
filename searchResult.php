<?php foreach($ret['items'] as $value) :?>
    <div class="m-3 seachResultContainer">
       <h5 class="title"><?php echo $value['htmlTitle'];?></h5>
        <a href ="<?php echo $value['link'];?>" rel="noreferrer noopener" target="_blank"><?php echo $value['htmlTitle'];?>||<?php echo $value['displayLink'];?></a>
        <p><?php echo $value['htmlSnippet'];?></p>
    </div>
<?php endforeach;?>