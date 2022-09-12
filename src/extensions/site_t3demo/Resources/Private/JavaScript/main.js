import './my-copyright';
import './my-keyvisual';

import ResetBanner from './ResetBanner';
import Navigation from './Navigation';

class Main {
	constructor() {
		new ResetBanner();
		new Navigation();
	}
}

new Main();
