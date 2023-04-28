<div class="generic-content">
    <form class="search-form" action="<?= esc_url(home_url('/')); ?>" method="get">
        <label class="headline headline--medium" for="s">Perform a new search</label>
        <div class="search-form-row">
            <input class="s" id="s" type="search" name="s" placeholder="What are you looking for?">
            <input class="search-submit" type="submit" value="Search">
        </div>
    </form>
</div>