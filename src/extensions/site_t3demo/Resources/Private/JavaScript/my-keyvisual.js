import componentStyles from './my-keyvisual.scss';

class MyKeyvisual extends HTMLElement {
  static get observedAttributes() {
    return ['header', 'imageSrc', 'text'];
  }

  connectedCallback() {
    this._renderWithShadowDom();
  }

  attributeChangedCallback() {
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
      <div class="b_keyvisual">
        <div class="b_keyvisual__contentcontainer b_keyvisual__contentcontainer--stage">
          <picture class="b_keyvisual__picture">
            <img src="${this.getAttribute('imageSrc')}"/>
          </picture>
          <div class="b_keyvisual__textblock">
            <h1 class="b_keyvisual__header">${this.getAttribute('header')}</h1>
            <p class="b_keyvisual__text">${this.getAttribute('text')}</p>
          </div>
        </div>
      </div>
    `
  }
}

customElements.define( 'my-keyvisual', MyKeyvisual );
