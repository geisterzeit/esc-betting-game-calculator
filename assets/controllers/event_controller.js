import {Controller} from '@hotwired/stimulus';
import {getComponent} from '@symfony/ux-live-component';

export default class extends Controller {
    static values = {
        guesserId: String,
        country: String
    }

    async initialize() {
        this.component = await getComponent(this.element);
    }

    updateGuess(event) {
        const guesserId = event.target.getAttribute('guesser-id');
        const countryRunningOrder = event.target.getAttribute('country');
        const guess = event.target.value;
        this.component.action('updateGuess', {guesserId: guesserId, country: countryRunningOrder, guess: guess});
    }

    selectNextInputField(event) {
        try {
            const nextColInput = event.target.parentElement.parentElement.nextElementSibling.children[4].firstElementChild;
            nextColInput.focus();
        } catch (ignored) {
        }
    }
}