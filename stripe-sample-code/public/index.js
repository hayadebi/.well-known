import { loadConnect } from "@stripe/connect-js";

const fetchClientSecret = async () => {
  // Fetch the AccountSession client secret
  const response = await fetch('/account_session.php', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  });
  if (!response.ok) {
    // Handle errors on the client side here
    const {error} = await response.json();
    console.log('An error occurred: ', error);
    document.querySelector('#container').setAttribute('hidden', '');
    document.querySelector('#error').removeAttribute('hidden');
    return undefined;
  } else {
    const {client_secret: clientSecret} = await response.json();
    document.querySelector('#container').removeAttribute('hidden');
    document.querySelector('#error').setAttribute('hidden', '');
    return clientSecret;
  }
}

  let stripeConnect;
  (async () => {
    try {
      stripeConnect = await loadConnect();
    } catch (error) {
      console.log('An error occurred: ', error);
      document.querySelector('#container').setAttribute('hidden', '');
      document.querySelector('#error').removeAttribute('hidden');
      return;
    }
    const clientSecret = await fetchClientSecret();
    if (clientSecret) {
      // Initialize StripeConnect after the window loads
      const instance = stripeConnect.initialize({
        // This is your test publishable API key.
        publishableKey: "pk_test_51O1lb3HlibvpbnGQ4Q17tGwkXZeOKcMsfg5NSY0FqU0cQFZoXOa0Kho2o3VoD5mkANmNumfMg74COldCmtad01Jx00ionxlMf8",
        clientSecret,
        appearance: {
          overlays: 'dialog',
          variables: {
            colorPrimary: '#625afa',
          },
        },
        refreshClientSecret: async () => {
          return await fetchClientSecret();
        }
      });
      const container = document.getElementById("container");
      const onboardingComponent = instance.create("account-onboarding");
      container.appendChild(onboardingComponent);
    }
  })();