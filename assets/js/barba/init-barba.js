import barba from '@barba/core';

// create the custom event for barba
window.dhBarbaBeforeAppear = new Event('dh_barba_before_appear');
window.dhBarbaAppear = new Event('dh_barba_appear');
window.dhBarbaAfterAppear = new Event('dh_barba_after_appear');
window.dhBarbaLeave = new Event('dh_barba_leave');
window.dhBarbaAfterLeave = new Event('dh_barba_after_leave');
window.dhBarbaBeforeEnter = new Event('dh_barba_before_enter');
window.dhBarbaAfterEnter = new Event('dh_barba_after_enter');

barba.init({
  debug: true,
  transitions: [
    // default
    {
      once({ current, next, trigger}) {
        window.dispatchEvent(new CustomEvent('dh_barba_enter', {
          'detail':
            {
              next: next.container, trigger: trigger
            }
          }));
          
        window.dispatchEvent(new CustomEvent('dh_barba_after_enter', {
          'detail':
            {
              next: next.container,
              current: current.container
            }
          }));
      },
      leave({ current, next, trigger }) {
        
      },
      enter({ current, next, trigger }) {
        window.dispatchEvent(new CustomEvent('dh_barba_enter', {
        'detail':
          {
            next: next.container, trigger: trigger
          }
        }));
      },
      afterEnter({ current, next, trigger }) {
        window.dispatchEvent(new CustomEvent('dh_barba_after_enter', {
          'detail':
            {
              next: next.container,
              current: current.container
            }
          }));
      }
    },
]
});