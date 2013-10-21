$(document).ready(function() {
	String.prototype.pad = function(padString, length) {
		var str = this;
		while (str.length < length)
			str = padString + str;
		return str;
	}
	
	var baseUrl = $("body").attr("data-baseurl");
	
	var stationId = parseInt($("#page-dashboard .schedule-table").attr("data-stationid"), 10);
	
	var RowView = Backbone.View.extend({
		el: null,
		initialize: function() {
			this.$el = $('<tr><td class="row-name"></td><td class="row-time"></td></tr>');
			if (this.model.get("id") === stationId) {
				this.$el.addClass("highlight-row");
			}
			this.onNameChanged();
			this.onTimeChanged();
			this.model.on("change:name", this.onNameChanged, this);
			this.model.on("change:startTime", this.onTimeChanged, this);
		},
		onNameChanged: function() {
			this.$el.find(".row-name").html(this.model.get("name"));
		},
		onTimeChanged: function() {
			this.$el.find(".row-time").html(this.model.get("startTime").getHours().toString().pad("0", 2)+":"+this.model.get("startTime").getMinutes().toString().pad("0", 2)+":"+this.model.get("startTime").getSeconds().toString().pad("0", 2));
		}
	});
	
	var TBodyView = Backbone.View.extend({
		el: $("#page-dashboard .schedule-table tbody").first(),
		rowViews: null,
		initialize: function() {
			this.$el.html("");
			this.rowViews = [];
		},
		addRow: function(model) {
			// create view
			var view = new RowView({model: model});
			this.rowViews.push(view);
			this.$el.append(view.$el);
		},
		removeRow: function(model) {
			var view = _.findWhere(rowViews, {model: model});
			view.remove();
			this.rowViews.splice(_.indexOf(this.rowViews, view)-1, 0);
		},
		clearRows: function() {
			_.each(this.rowViews, function(view) {
				view.remove();
			}, this);
			this.rowViews = [];
		}
	});
	var tBodyView = new TBodyView();
	
	var Station = Backbone.Model.extend({
		initialize: function() {},
		defaults: {
			id: null,
			startTime:  null,
			participationType: null,
			name: null
		}
	});
	
	var StationsCollection = Backbone.Collection.extend({
		model: Station,
		initialize: function() {
			this.on("add", this.onModelAdded, this);
			this.on("remove", this.onModelRemoved, this);
			this.on("sort", this.onSort, this);
		},
		comparator: function(model) {
			return model.get("startTime");
		},
		onModelAdded: function(model) {
			tBodyView.addRow(model);
		},
		onModelRemoved: function(model) {
		
			tBodyView.removeRow(model);
		},
		onSort: function() {
			tBodyView.clearRows();
			_.each(this.models, function(model) {
				tBodyView.addRow(model);
			});
		}
	});
	var stationsCollection = new StationsCollection();
	
	function updateData() {
		jQuery.ajax(baseUrl+"ajax_request", {
			success: function(data) {
				var updated = false;
				var foundModels = [];
				_.each(data.response, function(a) {
					var station = _.findWhere(stationsCollection.models, {id: a.id});
					foundModels.push(station);
					if (station !== undefined) {
						if (station.get("startTime").getTime()/1000 !== a.live_time) {
							station.set("startTime", new Date(a.live_time*1000));
							console.log("INFO: Time updated.");
							updated = true;
						}
					}
					else {
						stationsCollection.add({
							id: a.id,
							startTime: new Date(a.live_time*1000),
							participationType: a.participation_type,
							name: a.name
						});
						updated = true;
					}
				}, this);
				
				_.each(_.difference(foundModels, stationsCollection.models), function(a) {
					stationsCollection.remove(a);
				}, this);
				
				if (updated) {
					stationsCollection.sort();
				}
			},
			error: function() {
				console.log("ERROR: Error retrieving station times.");
			},
			timeout: 3000,
			dataType: "json",
			data: {
				action: "get_station_times"
			},
			type: "GET"
		});
	}
	updateData();
	setInterval(updateData, 16000);
	
});