import {startStimulusApp} from '@symfony/stimulus-bundle';
import LiveController from '@symfony/ux-live-component';

const app = startStimulusApp();
app.register('live', LiveController);
