import React, { Component } from 'react';
import { withScriptjs, withGoogleMap, GoogleMap, DirectionsRenderer } from "react-google-maps";

const Map = withScriptjs(withGoogleMap(({directions}) =>
  <GoogleMap
    defaultZoom={8}
    defaultCenter={{ lat: -22.911, lng: -43.2094 }}
  >
    {directions && (<DirectionsRenderer directions={directions} />)}

  </GoogleMap>
))

export default Map;
