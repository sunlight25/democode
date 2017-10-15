<section id="features" class="compair-section">
    <div class="col-md-12">
        <div class="col-md-12">
            <h4 class="h4-responsive"><?php print t("Compare Schools"); ?></h4>
        </div>
        <?php if (!empty($comparison_table)) { ?>
            <div class="col-md-12">
                <div class="table-responsive data-table-center">
                    <?php
                    //print render($only_diff_checkbox);
                    //print render($comparison_table);                    
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive data-table-center">
                    <?php print render($comparison_tab); ?>
                </div>
            </div>        
        <?php } else { ?>
            <div class="col-md-12">
                <div class="table-responsive data-table-center">                                                
                    <div id="compare-content-wrapper" class="table-responsive data-table-center">
                        <table class="sticky-header">                        
                            <td><p>Please add schools for Comparison.</p></td>
                        </table>
                    </div>                                          
                </div>
            </div>
        <?php } ?>
    </div>
</section>
