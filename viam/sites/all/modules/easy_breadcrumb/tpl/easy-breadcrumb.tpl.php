<?php if ($segments_quantity > 0): ?>
    <nav class="search-filter v-blue">
        <div itemscope class="easy-breadcrumb" itemtype="<?php print $list_type; ?>">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12">
                            <?php foreach ($breadcrumb as $i => $item): ?>
                            <?php print $item; ?>
                                <?php if ($i < $segments_quantity - $separator_ending): ?>
                                    <span class="breadcrumb easy-breadcrumb_segment-separator"><?php //print $separator; ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>