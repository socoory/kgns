<?php if (!defined("__KGNS__")) exit; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.2/backbone.js"></script>

<div class="content text-center">
	<form id="write_form" class="col-md-10 center_block" action="<?=URL?>/timeline/post" method="post">
		<div class="form-group basebox">
			<textarea id="textbox" class="pd_15" name="content" rows="10" placeholder="content"></textarea>
			<div id="attach_placeholder"></div>
			<div id="toolbox" class="pd_10">
				<a class="btn btn-default btn_camera pd_15"></a>
				<a class="btn btn-default btn_attach pd_15"></a>
				<a class="btn btn-default btn_food pd_15"></a>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="submit" class="btn btn-danger">SUBMIT</button>
		</div>
	</form>
</div>

<script type="text/template" id="attach_form">
	<input id="attach" type="file" accept="<%= accept %>" style="display: none;" />
</script>

<script type="text/template" id="image_holder">
	<div id="attach_image_title" class="attach_title text-center pd_5">Attached images</div>
	<ul id="image_placeholder" class="row"></ul>
</script>

<script type="text/template" id="file_holder">
	<div id="attach_file_title" class="attach_title text-center pd_5">Attached files</div>
	<ul id="file_placeholder" class="row"></ul>
</script>

<script type="text/template" id="lunch_holder">
	<div id="lunch_title" class="attach_title text-center pd_5">Added lunch menu</div>
	<div class="form-inline pd_15">
		<div class="input-group">
			<label class="input-group-addon">Menu</label>
			<input type="text" class="form-control input-sm" name="menu" />
			<a class="input-group-addon btn" id="btn_addLunch">Add</a>
		</div>
	</div>
	<ul id="lunch_placeholder" class="row"></ul>
</script>

<script type="text/template" id="attach_image">
	<li class="attach_thumb" style="background-image: url('<%= image %>')">
		<a class="detach_button pd_10"></a>
		<input type="hidden" name="files[]" value="<%= fileNo %>" />
	</li>
</script>

<script type="text/template" id="attach_file">
	<li class="attach_fileinfo pd_lr_10 text-left">
		<span><%= fileName %></span>
		<a class="detach_button pd_10"></a>
		<input type="hidden" name="files[]" value="<%= fileNo %>" />
	</li>
</script>

<script type="text/template" id="lunch">
	<span class="va_mid"><%= menu %></span>
	<a class="detach_button pd_10"></a>
	<input type="hidden" name="lunch[]" value="<%= menu %>" />
</script>

<script type="text/template" id="blind_template">
	<div id="blind_wrap" style="height: <%= height %>px;">
	    <div id="blind"></div>
	    <div class="pos_t_50 container-fluid">
	        <div id="progress_wrap" class="col-sm-6 basebox center_block">
	            <div class="progress_title text-center">
	                <span>uploading file...</span>
	            </div>
	            <div class="progress_body text-center">
	                <div class="progress_con">
	                    <div id="progress_bar"></div>
	                </div>
	                <div class="progress_file_name">
	                    <span><%= filename %></span>
	                </div>
	                <button id="btn_uploadCancel" class="btn btn-danger btn-sm">cancel</button>
	            </div>
	        </div>
		</div>
	</div>
</script>

<script>

//******************************************//
//                backbonejs                //
//******************************************//

(function ($) {
	var Img = Backbone.Model.extend({
		initialize: function() {
		},
		url: '.',
		image: null,
		fileNo: null
	});
	
	var Imgs = Backbone.Collection.extend({
		initialize: function (models, options) {
		},
		url: '.',
		model: Img,
		empty: function() {
			return !this.length;
		}
	});
	
	var imgs = new Imgs();
	
	var FileInfo = Backbone.Model.extend({
		initialize: function() {
		},
		url: '.',
		fileName: null,
		fileNo: null
	});
	
	var FileInfos = Backbone.Collection.extend({
		initialize: function (models, options) {
		},
		url: '.',
		model: FileInfo,
		empty: function() {
			return !this.length;
		}
	});
	
	var files = new FileInfos();
	
	var Lunch = Backbone.Model.extend({
		initialize: function() {
		},
		url: '.',
		menu: null
	});
	
	var Lunches = Backbone.Collection.extend({
		initialize: function (models, options) {
		},
		url: '.',
		model: Lunch,
		empty: function() {
			return !this.length;
		}
	});
	
	var lunches = new Lunches();
	
	var ImgView = Backbone.View.extend({
		tagName: "attach",
		template: _.template($("#attach_image").html()),
		
		events: {
			"click a.detach_button": "clear"
		},
		
		initialize: function() {
	    	this.listenTo(this.model, 'change', this.render);
	    	this.listenTo(this.model, 'destroy', this.remove);
	    },
	    
	    render: function() {
	    	$(this.el).html(this.template(this.model.toJSON()));
	    	return this.el;
	    },
	    
	    clear: function() {
	    	this.model.destroy();
	    }
	});
	
	var FileView = Backbone.View.extend({
		tagName: "attach",
		template: _.template($("#attach_file").html()),
		
		events: {
			"click a.detach_button": "clear"
		},
		
		initialize: function() {
	    	this.listenTo(this.model, 'change', this.render);
	    	this.listenTo(this.model, 'destroy', this.remove);
	    },
	    
	    render: function() {
	    	$(this.el).html(this.template(this.model.toJSON()));
	    	return this.el;
	    },
	    
	    clear: function() {
	    	this.model.destroy();
	    }
	});
	
	var LunchView = Backbone.View.extend({
		tagName: "li",
		template: _.template($("#lunch").html()),
		
		events: {
			"click a.detach_button": "clear"
		},
		
		initialize: function() {
	    	this.listenTo(this.model, 'change', this.render);
	    	this.listenTo(this.model, 'destroy', this.remove);
	    },
	    
	    render: function() {
	    	$(this.el).addClass('lunch')
	    	$(this.el).addClass('pd_lr_10')
	    	$(this.el).addClass('text-center')
	    	$(this.el).html(this.template(this.model.toJSON()));
	    	return this.el;
	    },
	    
	    clear: function() {
	    	this.model.destroy();
	    }
	});
	
	var LunchHolder = Backbone.View.extend({
		tagName: "div",
		template: _.template($("#lunch_holder").html()),
		events: {
			"click a#btn_addLunch": "addLunch",
			"keypress input[name=menu]": "createOnEnter"
		},
		
		initialize: function() {
			this.listenTo(lunches, 'add', this.addMenu);
			this.listenTo(lunches, 'remove', this.checkMenusEmpty);
		},
		
		render: function() {
			$(this.el).append(this.template({}));
			return this.el;
		},
		
		addLunch: function() {
			if($("input[name=menu]").val() == "")
				return;
			lunches.create({menu: $("input[name=menu]").val()});
		},

		addMenu: function(lunch) {
			var view = new LunchView({model: lunch});
			$("#lunch_placeholder").prepend(view.render());
		},
		
		createOnEnter: function(event) {
			if(event.keyCode != 13)
				return;
			if($("input[name=menu]").val() == "")
				return;
				
			lunches.create({menu: $("input[name=menu]").val()});
			$("input[name=menu]").val("");
			event.preventDefault();
		},
		
		checkMenusEmpty: function() {
			// if(lunches.empty()) {
				// $("#lunch_title").remove();
				// $("#lunch_placeholder").remove();
			// }
		},
	});
	
	var AppView = Backbone.View.extend({
 		el: $("body"),
 		
		initialize: function () {
			// this.imgs = new Imgs( null, {view: this});
			this.listenTo(imgs, 'add', this.addImage);
			this.listenTo(imgs, 'remove', this.checkImagesEmpty);
			this.listenTo(files, 'add', this.addFile);
			this.listenTo(files, 'remove', this.checkFilesEmpty);
			this.type = null;
		},
		
		events: {
			"click .btn_camera":  "selectPhoto",
			"click .btn_attach":  "selectFile",
			"submit #write_form": "validateLength",
			"change #attach": "uploadFile",
			"click .btn_food": "createLunch",
			"click #btn_uploadCancel": "uploadCancel"
		},
		
		clearInput: function() {
			if($('#attach').length > 0 && $('#attach').val() == "") {
				$('#attach').remove();
			}
		},
		
		createLunch: function() {
			if($("#lunch_placeholder").length == 0) {
				var lunchHolder = new LunchHolder();
				$("#attach_placeholder").append(lunchHolder.render());
			}
		},
		
		selectPhoto: function () {
			this.clearInput();
			this.type = "i";
			var form = _.template($('#attach_form').html());
			$('#toolbox').append(form({accept: 'image/*'}));
			$('#attach').click();
		},
		
		selectFile: function () {
			this.clearInput();
			this.type = "f";
			var form = _.template($('#attach_form').html());
			$('#toolbox').append(form({accept: '*'}));
			$('#attach').click();
		},
		
		uploadFile: function (model) {
			var formData = new FormData();
			var self     = this;
			formData.append('attach', $("#attach")[0].files[0]);
			
			this.xhr = $.ajax({
				url:  '../attach',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: this.addThumb,
				error: this.uploadError,
		        xhr: function() { return self.progress(self); },
		        fileType: this.type
			});
		},
		
		progress: function(context) {
	        myXhr = $.ajaxSettings.xhr();
	        if(myXhr.upload){
	        	var blind = _.template($("#blind_template").html());
	        	$("body").prepend(blind({height: window.innerHeight, filename: $("#attach")[0].files[0].name}))
	            myXhr.upload.addEventListener('progress', context.showProgress, false);
	        } else {
	            console.log("Uploadprogress is not supported.");
	        }
	        return myXhr;
	    },
	    
	    showProgress: function(evt) {
	    	if (evt.lengthComputable) {
	    		$("#progress_bar").css("width", '' + ((evt.loaded/evt.total) * 100) + '%');
			}
	    },
	    
	    uploadError: function() {
	    	if($("#attach").length > 0) {
				$("#attach").remove();
				$("#blind_wrap").remove();
			}
			
			alert("An error has been occured while uploading.");
	    },
	    
	    uploadCancel: function() {
	    	console.log(this.xhr.readyState);
	    	if(this.xhr.readyState != 4) {
	    		this.xhr.abort();
	    	}
	    },
		
		addThumb: function(res) {
			$("#attach").remove();
			$("#blind_wrap").remove();
			
			if(res) {
				obj = JSON.parse(res);
				if(this.fileType == 'i') {
					if($("#image_placeholder").length == 0) {
						var imageHolder = _.template($("#image_holder").html());
						$("#attach_placeholder").append(imageHolder());
					}
					
					imgs.create({image: '../' + obj.fileUrl, fileNo: obj.fileNo});
				}
				else if(this.fileType == 'f') {
					if($("#file_placeholder").length == 0) {
						var fileHolder = _.template($("#file_holder").html());
						$("#attach_placeholder").append(fileHolder());
					}
					
					files.create({fileName: obj.fileName, fileNo: obj.fileNo});
				}
			}
		},

		addImage: function(img) {
			var view = new ImgView({model: img});
			$("#image_placeholder").append(view.render());
		},

		addFile: function(f) {
			var view = new FileView({model: f});
			$("#file_placeholder").append(view.render());
		},
		
		checkImagesEmpty: function() {
			if(imgs.empty()) {
				$("#attach_image_title").remove();
				$("#image_placeholder").remove();
			}
		},
		
		checkFilesEmpty: function() {
			if(files.empty()) {
				$("#attach_file_title").remove();
				$("#file_placeholder").remove();
			}
		},
		
		validateLength: function() {
			if($('#textbox').val().length < 10) {
				alert('내용을 10 자 이상 작성해주세요.');
				return false;
			}
		}
	});
	
	var appview = new AppView;
})(jQuery);
</script>