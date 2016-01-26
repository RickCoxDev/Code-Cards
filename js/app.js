(function(){

	var app = angular.module('codeCards', ['ngCookies', 'ui.bootstrap', 'angular-flippy']);

	// Controller for Navigation Bar
	app.controller("navbarController", ["$scope", "$window", "$cookies", function($scope, $window, $cookies){
		
		// Watches browser cookies to see if the user is
		// signed in
		$scope.$watch(function(){
			watch = $cookies.get("authorized");
			return watch;
		}, 
		function(newVal, oldVal){
			if (newVal == "true") {
				$scope.signIn = $cookies.get("user").toUpperCase();
				$scope.loggedIn = true;
			}
			else {
				$scope.signIn = "";
				$scope.loggedIn = false;
			}
		});

		// Logout function
		$scope.logOut = function(){
			$cookies.put("authorized", "false");
			$cookies.put("user", "");
			$window.location.href = "login.html";
		};
	}]);

	app.controller("loginController", ["$scope", "$http", "$window", "$cookies", function($scope, $http, $window, $cookies){

		/*if ($cookies.get("authorized") == "true") {
			$window.location.href = "account.html"
		}*/

		$scope.showAlert = false;
		$scope.tab = 1;

		// Both of these functions controls
		// which tab is display
		$scope.isSet = function(tabNum){
			return $scope.tab === tabNum;
		};

		$scope.set = function(newTab){
			$scope.showAlert = false;
			$scope.tab = newTab;
		};

		// Login function
		$scope.checklogin = function(){
			// If form is complete
			if ($scope.login_usr !== undefined && $scope.login_pwd !== undefined) {

				var request = $http({
		    			method: "GET",
		   				url: "api/1.0/hello/Rick",
		    			data: {
		        			user: $scope.login_usr,
		        			password: $scope.login_pwd
		    			},
		    			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				});

				request.success(function (data) {
	    			console.log(data);

	    			if (data.error === false) {
	    				$cookies.put("user", data.output);
	    				$cookies.put("authorized", "true");
	    				$window.location.href = "account.html";
	    			}
	    			else {
	    				$scope.showAlert = true;
	    				$scope.alert = {type: "warning", msg: "Please enter a valid email and password."};
	    			}
				});
			}
			else {
				$scope.showAlert = true;
				$scope.alert = {type: "warning", msg: "Please complete the login form."};
			}	
		};

		// User registration function
		$scope.register = function(){

			// If form is complete
			if ($scope.register_em !== undefined && $scope.register_pwd !== undefined && $scope.register_cfrm !== undefined) {
				
				// If password and the password 
				// confirmation are the same
				if ($scope.register_pwd === $scope.register_cfrm) {
					var request = $http({
			    			method: "POST",
			   				url: "php/register.php",
			    			data: {
			        			email: $scope.register_em,
			        			username: $scope.register_usr,
			        			password: $scope.register_pwd
			    			},
			    			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
					});

					request.success(function (data) {
						console.log(data);
						if (data.error == "email") {
			    			$scope.showAlert = true;
			    			$scope.alert = {type: "warning", msg:"That email is already being used."};
		    			}
		    			else if (data.error == "username") {
			    				$scope.showAlert = true;
			    				$scope.alert = {type: "warning", msg:"That username is already being used."};
			    		}
			    		else if (data.error === false) {
					    			$cookies.put("user", data.output);
					    			$cookies.put("authorized", "true");
				    				$window.location.href = "account.html";
			    		}
					});
				}
				else {
					$scope.showAlert = true;
					$scope.alert = {type: "danger", msg: "The passwords do not match."};
				}
			}
			else {
				$scope.showAlert = true;
				$scope.alert = {type: "warning", msg: "Please complete the registration form."};
			}
		};
	}]);

	// Controller for the main account page
	app.controller("dashboardController", ["$scope", "$http", "$window", "$cookies", function($scope, $http, $window, $cookies){
		
		if ($cookies.get("authorized") != "true") {
			$window.location.href = "login.html";
		}

		// Fetches the all deck names
		var request = $http({
			method: "POST",
			url: "php/decks.php",
			data: {
				user: $cookies.get("user")
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});

		request.success(function(data) {
			if (data.length === 0){
				$scope.decks = false;
			}
			else {
				$scope.decks = data;
			}
			console.log($scope.decks);
		});

		// Redirects to deck edit page
		$scope.edit = function(deck) {
			$cookies.put("deck", deck);
			$window.location.href = "edit.html";
		};

		// TODO: make modal to confirm deletion
		// Deletes deck
		$scope.delete = function(deck){
			var ans = window.confirm("Are you sure you you want to delete " + deck + "?");
			if (ans){
				var request = $http({
					method: "POST",
					url: "php/delete.php",
					data: {
						user: $cookies.get("user"),
						deckName: deck
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				});

				request.success(function(data){
				$scope.decks = data;
				$window.location.href = "account.html";
			});
			}
		};

		// Creates new deck and redirects to edit page
		$scope.newDeck = function() {
			$cookies.put("deck", "");
			$window.location.href = "edit.html";
		};

		// Redirects to the study page
		$scope.study = function(deck) {
			$cookies.put("deck", deck);
			$window.location.href = "study.html";
		};
	}]);

	// Controller for the deck edit page
	app.controller("editController", ["$scope", "$http", "$window", "$cookies", function($scope, $http, $window, $cookies){

		var deck = $cookies.get("deck");

		// Fetches all the cards in the requested deck
		var request = $http({
			method: "POST",
			url: "php/cards.php",
			data: {
				user: $cookies.get("user"),
				deckName: deck
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});

		request.success(function(data) {
			console.log(data);
			$scope.cards = data;
			$scope.deckName = data[0].deck;
		});

		// Adds blank card to current deck
		$scope.addCard = function(){
			$scope.cards.push({term:"",description:""});
		};

		// Deletes card
		$scope.delete = function(index){
			$scope.cards.splice(index, 1);
		};

		// Saves current state of the deck
		$scope.save = function(){
			var request = $http({
			method: "POST",
			url: "php/save.php",
			data: {
				user: $cookies.get("user"),
				cards: $scope.cards,
				deckName: $scope.deckName
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});

			request.success(function(data) {
				console.log(data);
				$window.location.href = "account.html";
			});
		};
	}]);

	// Controller for the deck study page
	app.controller("studyController", ["$scope", "$http", "$window", "$cookies", function($scope, $http, $window, $cookies){

		var deck = $cookies.get("deck");

		// Fetches all the cards in the selected deck
		var request = $http({
			method: "POST",
			url: "php/cards.php",
			data: {
				user: $cookies.get("user"),
				deckName: deck
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});

		request.success(function(data) {
			$scope.cards = data;
			$scope.deckName = data[0].deck;
			$scope.index = 1;
			$scope.totalItems = $scope.cards.length;
			console.log($scope.totalItems);
		});

		$scope.showCard = function(card){
			return card === $scope.index-1;
		};
	}]);

})();
