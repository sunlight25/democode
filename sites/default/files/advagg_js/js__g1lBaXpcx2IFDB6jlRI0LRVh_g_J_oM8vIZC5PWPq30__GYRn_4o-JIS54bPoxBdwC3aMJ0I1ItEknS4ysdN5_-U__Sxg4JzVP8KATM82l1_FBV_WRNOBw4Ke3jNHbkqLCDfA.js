/* Source and licensing information for the line(s) below can be found at http://www.ukschool.net/sites/all/modules/devel/devel_krumo_path.js. */
(function(t){Drupal.behaviors.devel={attach:function(i,l){t('.krumo-footnote .krumo-call').once().before('<img style="vertical-align: middle;" title="Click to expand. Double-click to show path." src="'+l.basePath+'misc/help.png"/>');var e=[],o=[];function n(i){e.push(t(i).html());o.push(t(i).siblings('em').html().match(/\w*/)[0]);if(t(i).closest('.krumo-nest').length>0){n(t(i).closest('.krumo-nest').prev().find('.krumo-name'))}};t('.krumo-child > div:first-child',i).dblclick(function(h){if(t(this).find('> .krumo-php-path').length>0){t(this).find('> .krumo-php-path').remove()}
else{n(t(this).find('> a.krumo-name'));var l='';for(var i=e.length-1;i>=0;--i){if((e.length-1)==i)l+='$'+e[i];if(typeof e[(i-1)]!=='undefined'){if(o[i]=='Array'){l+='[';if(!/^\d*$/.test(e[(i-1)]))l+='\'';l+=e[(i-1)];if(!/^\d*$/.test(e[(i-1)]))l+='\'';l+=']'};if(o[i]=='Object')l+='->'+e[(i-1)]}};t(this).append('<div class="krumo-php-path" style="font-family: Courier, monospace; font-weight: bold;">'+l+'</div>');e=[];o=[]}})}}})(jQuery);;
/* Source and licensing information for the above line(s) can be found at http://www.ukschool.net/sites/all/modules/devel/devel_krumo_path.js. */
