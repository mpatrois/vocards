import App from './App';
import Upload from './components/Upload/Upload';
import Sorts from './Sorts';
import Setup from './Setup';

const routes = [
  {
    path: '/',
    name: 'sort',
    component: App,
  },
  {
    name: 'upload',
    path: '/upload',
    component: Upload,
  },
  {
    name: 'setup',
    path: '/setup',
    component: Setup,
  },
  {
    name: 'sorts',
    path: '/sorts',
    component: Sorts,
  },
];

export default routes;
