Drupal.theme.prototype.CToolsULModal = function () {
  var html = '';  
  html += '<div id="ctools-modal" class="modal">';
  //тут наш html
  html += '<div id="ul_modal-block" class="left-align mb-0">';
  html += '<div class="row">';  
  //html += '              <span id="modal-title" class="modal-title"></span>';
  html += '<div id="modal-title" class="col s12"><h4 class="mb-4"><i class="fa mr-2 fa-shopping-cart v-gold-text" aria-hidden="true"></i> Add this product to your Cart</h4></div>';  
  html += '              <span class="popups-close"><a class="close" href="#"></a></span>';  
  html += '              <div class="clear-block"></div>';  
  html += '           <div class="col s12">';
  html += '             <div class="modal-scroll"><div id="modal-content" class="modal-content popups-body"></div></div>';  
  html += '          </div>';  
  html += '         <div class="clearboth"></div>';
  html += ' </div>';
  html += ' </div>';
  html += '</div>';

  return html;

}