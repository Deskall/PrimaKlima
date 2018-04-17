//Custom Javascript Function Block
(function($) {
    $.entwine("ss", function($) {
        // $(".ss-gridfield-add-new-multi-class select[name='BlockType']").entwine({
        //      onadd: function() {
        //          this.update();
        //      },
        //      onchange: function() {
        //          this.update();
        //      },
        //      update: function() {
        //          var btn = this.parents(".ss-gridfield-add-new-multi-class").find(".ss-ui-button");
        //          var link = btn.data("href");
        //          var cls  = btn.parents(".ss-gridfield-add-new-multi-class").find("select[name='BlockType']").val();
        //          if(cls && cls.length){
        //             if (cls == "DuplicateBlock"){
        //                 $(".ss-gridfield-duplicate-block").css({"display":"inline-block"});
        //             }
        //             else{
        //                 $(".ss-gridfield-duplicate-block").css({"display":"none"});
        //                 btn.getGridField().showDetailView(link.replace("/{id}/{pageid}", '').replace("{class}", cls));
        //             }
        //          }
        //      }
        // });

        
        $(".ss-gridfield-add-new-multi-class select[name='GridFieldAddNewMultiClass[ClassName]']").entwine({
            onchange: function(){
                this._super();
                if (this.val() == "DuplicateBlock"){
                    this.parents('.ss-gridfield-add-new-multi-class').find('[data-add-multiclass]').hide();
                }
            }
        });
        //Duplicate Block
        $(".ss-gridfield-duplicate-block select[name='Block']").entwine({
             onadd: function() {
                 this.update();
             },
             onchange: function() {
                 this.update();
             },
             update: function() {
                 var btn = this.parents(".ss-gridfield-duplicate-block").find(".btn-duplicate-block");
                 var link = btn.data("href");
                 var block = btn.parents(".ss-gridfield-duplicate-block").find("select[name='Block']").val();
                 if(block && block > 0) {
                    btn.removeClass("disabled");
                    var path = window.location.pathname;
                    //if not in page but in parent block
                    if (path.indexOf("/edit/show/") == - 1){
                        var page = path.substr(path.indexOf("/edit/EditForm/") + 15);
                    }
                    else{
                        var page = path.substr(path.indexOf("/edit/show/") + 11);
                    }
                    
                    var finallink = link.replace("{id}", block).replace("{pageid}",page);
                    btn.getGridField().showDetailView(finallink);
                }
                else{
                   btn.addClass("disabled");
                }
            }
        });

        //Virtual Block
    });
})(jQuery);