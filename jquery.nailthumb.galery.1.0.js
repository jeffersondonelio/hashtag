
;(function($) {

	/**
	 * Plugin
	 */

	$.fn.imagesGalery = function(options) {

		var args = arguments;

		a = this.each(function() {
			switch(options.images.length){
				case 1:
					options.height = '204px';
					options.width = '306px';
				break;
				case 2:
					options.height = '94px';
					options.width = '306px';
				break;
				case 3:
					options.height = ['94px','94px','94px'];
					options.width = ['306px','151px','151px'];
				break;
				case 4:
					options.height = '94px';
					options.width = '149px';
				break;
				case 5:
					options.height = ['80px','80px','80px','100px','100px'];
					options.width = ['98px','98px','98px','149px','149px'];
				break;
				default:
					options.height = ['80px','80px','80px','100px','100px'];
					options.width = ['98px','98px','98px','149px','149px'];
                                break;
			}
			imagesGalery(options);
		});

		options = onImageLoaded(options);

		return a;
	};

	/**
	 * Plugin default options
	 */

	$.fn.imagesGalery.defaults = {
		images: [],
		lenght:0
	};
	
        $.fn.imagesGalery.items = [];
        $.fn.imagesGalery.loadThumb = [];
        
	var count_array_img = 0;
	var count_qtd_img = 0;

	//-return vertical ou horizontal
	function imagesGalery(opts) {
		this.$modal = null;

		init(opts);
	}

	//-return vertical ou horizontal
	init = function(opts)  {
		//-carregar as divs e imgs
		opts = createDiv(opts);
	}

	createDiv = function(opts){
            a = false;
            for(var i=0;i<opts.images.length;i++){
                var item = $("#"+opts.id);

                item.append(
                    $('<a>', {
                        class: 'nailthumb-container img-'+opts.images.length,
                        'data-source' : opts.images[i],
                        'href' : opts.images[i]
                    }).append(
                        $('<img>', {
                            class : 'img-galery',
                            src: opts.images[i],
                            on: {
                                load: function(event) {
                                    imgLoaded(opts);
                                }
                            }
                        })
                    )
                );

                setNailThumb(opts);
            }

            verifyViewMore(opts);
            return opts;
	}

        imgLoaded = function(opts){
            if(count_qtd_img < opts.images.length){
                count_qtd_img++;
            }else{
                count_qtd_img = 0;
                //-$("#"+opts.id+' .nailthumb-container').nailthumb();
            }
        }

	verifyViewMore = function(opts){
            if(opts.images.length > 5){
                qtd = 0;
                $("#"+opts.id+" .nailthumb-container").each(function(){
                    if(qtd === 4) $(this).append(
                        $('<div>',{
                            class:'view-all'
                        }).append(
                            $('<span>',{class:'view-all-cover'})
                        ).append(
                            $('<span>',{
                                class:'view-all-text',
                                text:'Ver +'+parseInt(opts.images.length-qtd)
                            })
                        )
                    );
                    if(qtd > 4) $(this).addClass('thumb_none');
                    qtd++;
                });
            }
            
            verifyComplete(opts);
	};

	onImageLoaded = function(options){
            w = $("#"+options.id).find("img.img-galery:first")[0].naturalWidth;
            h = $("#"+options.id).find("img.img-galery:first")[0].naturalHeight;
            options.postion = ((h > w) ? "vertical" : "horizontal");

            return options;
	};

	setNailThumb = function(opts){
            if(Array.isArray(opts.width)){
                $("#"+opts.id).find('.nailthumb-container').nailthumb({width:opts.width[count_array_img],height:opts.height[count_array_img]});
                
                count_array_img++;
                if(count_array_img >= opts.images.length) count_array_img = 0;
            }else{
                $("#"+opts.id).find('.nailthumb-container').nailthumb({width:opts.width,height:opts.height});
                count_array_img = 0;
            }
	};
        
	verifyComplete = function(opts){
            $.fn.imagesGalery.items.push(opts);

            /*
            for(var i=0;i<$.fn.imagesGalery.items.length;i++){
                if(!$.fn.imagesGalery.loadThumb[parseInt(opts.number)]){
                    $('#'+$.fn.imagesGalery.items[i].id).find('.nailthumb-container').nailthumb().css('display','block');
                    $('#row_'+parseInt($.fn.imagesGalery.items[i].number)).hide();
                }
                $.fn.imagesGalery.loadThumb.push(parseInt(opts.number));
            }
            window.addEventListener('load', function () {  
                if(opts.images.length === $('#'+opts.id+" .nailthumb-container").length){
                    for(var i=0;i<$.fn.imagesGalery.items.length;i++){
                        console.log($.fn.imagesGalery.items[i]);
                        $('#'+$.fn.imagesGalery.items[i].id).find('.nailthumb-container').css('display','block');
                        $('#'+$.fn.imagesGalery.items[i].id).find('.nailthumb-container').nailthumb();
                    }
                    $.fn.imagesGalery.loadThumb.push({"parseInt(opts.number)":parseInt(opts.number)});
                }
            });
            */
	};

})(jQuery);
