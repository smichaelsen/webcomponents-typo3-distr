import componentStyles from './my-copyright.scss';

class MyCopyright extends HTMLElement {
  connectedCallback() {
    this._renderWithShadowDom();
  }

  _renderWithShadowDom() {
    const shadow = this.attachShadow({ mode: 'closed' });
    shadow.innerHTML = `
        <style>
          ${componentStyles}
        </style>
        ${this._render()}
      `;
  }

  _render() {
    return `
      <p class="b_copyright">
				<span dir="ltr">
					&copy; ${new Date().getFullYear()}
					<a href="https://typo3.org" class="b_copyright__link" target="_blank" rel="noreferrer">TYPO3 Association.</a>
					<a href="https://b13.com" class="b_copyright__link" target="_blank" rel="noreferrer">Made with ❤ by b13.</a>
					<a href="https://github.com/smichaelsen/typo3-webcomponents" class="b_copyright__link" target="_blank" rel="noreferrer">Rendered with EXT:webcomponents</a>
				</span>
			</p>
    `
  }
}

customElements.define( 'my-copyright', MyCopyright );
