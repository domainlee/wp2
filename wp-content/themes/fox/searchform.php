<div class="searchform">
    <form role="search" method="get" action="<?php echo home_url();?>" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
        <input type="text" name="s" class="s" value="<?php echo get_search_query();?>" placeholder="<?php _e('Search...','wi');?>" />
        <button class="submit" role="button" title="<?php _e('Go','wi');?>"><i class="fa fa-search"></i></button>
    </form>
</div><!-- .header-search -->