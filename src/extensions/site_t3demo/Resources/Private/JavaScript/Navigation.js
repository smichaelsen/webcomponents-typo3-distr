/**
 * navigation
 */
class Navigation {

	constructor() {
		this.events();
	}

	events() {
		const navtrigger = document.getElementById('navtrigger');
		navtrigger.addEventListener('change', () => {
			this.toggleNavigation();
		})
	}

	/**
	 * toggle navigation
	 */
	toggleNavigation() {
		if (document.getElementById("navtrigger").checked === true) {
			this.disableScrolling();
		} else {
			this.enableScrolling();
		}
	}

	/**
	 * disable scrolling
	 */
	disableScrolling() {
		document.documentElement.classList.add("b_navi--open");
	}

	/**
	 * enable scrolling
	 */
	enableScrolling() {
		document.documentElement.classList.remove("b_navi--open");
	}
}

export default Navigation;
