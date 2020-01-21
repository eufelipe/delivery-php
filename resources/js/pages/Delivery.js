import axios from 'axios';
import React, { Component } from 'react';

import {DirectionsRenderer } from "react-google-maps";

import {
    Grid,
    CssBaseline,
    Typography,
    CircularProgress,
    Link,
    Breadcrumbs
} from '@material-ui/core';
import MuiAlert from '@material-ui/lab/Alert';

import Map from '../components/Map';
import {formatDate} from '../utils/Date';

const API_GOOGLE_MAPS_KEY = "AIzaSyDQrklMQx3scCo5dKR51Oy2ze7cULftjZ4";

function Alert(props) {
  return <MuiAlert elevation={6} variant="filled" {...props} />;
}

class Delivery extends Component {
      constructor () {
        super()
        this.state = {
          delivery: [],
          isLoading: false,
          errors: null,
          errorDirections: false
        }
      }

      componentDidMount () {
        const id = this.props.match.params.id
        this.setState({isLoading: true})
        axios.get(`/api/deliveries/${id}`)
        .then(response => {
          const {data: address} = response;
          this.setState({
            delivery:address,
            isLoading: false,
            errorDirections: false,
          })

            const DirectionsService = new google.maps.DirectionsService();
            DirectionsService.route({
                    origin: address.target_start,
                    destination: address.target_end,
                    travelMode: google.maps.TravelMode.DRIVING,
                }, (result, status) => {
                    if (status === google.maps.DirectionsStatus.OK) {
                    this.setState({
                        directions: result,
                        errorDirections: false
                    });
                    return;
                    }

                    this.setState({
                        errorDirections: true
                    });

                });
        })
        .catch(error => {
            this.setState({
              errors: error.response.data.message,
              isLoading: false
            })
          })
      }

      render () {
        const {
            delivery = [],
            isLoading = false,
            directions = null,
            errors = null,
            errorDirections = false
            } = this.state

        if(isLoading) {
            return <CircularProgress />
        }

        if(errors) {
            return <Alert severity="error">{errors}</Alert>
        }

          return (
              <>
               <CssBaseline />
                <Breadcrumbs aria-label="breadcrumb">
                    <Link color="inherit" href="/">
                        Página Inícial
                    </Link>
                    <Typography color="textPrimary">Entrega</Typography>
                </Breadcrumbs>

                <Grid container component="main">

                    <Grid item xs={12} sm={12} md={12} elevation={6} >
                        <Typography variant="h2" color="inherit" noWrap>
                        {delivery.client}
                        </Typography>
                        <hr />

                        <Typography variant="h6" color="inherit" noWrap >
                        Data da entrega: {formatDate(delivery.delivery_date)}
                        </Typography>

                        <Typography color="inherit" noWrap style={{ padding: 20}}>
                        Origem: <strong>{delivery.target_start}</strong> - Destino: <strong>{delivery.target_end}</strong>
                        </Typography>

                        {errorDirections && (
                           <Alert severity="error">Não foi possivel renderizar o mapa com os endereços informados </Alert>
                        )}

                        {!errorDirections && (
                            <Map directions={directions}
                                googleMapURL={`https://maps.googleapis.com/maps/api/js?key=${API_GOOGLE_MAPS_KEY}&v=3.exp&libraries=geometry,drawing,places`}
                                loadingElement={<div style={{ height: `100%` }} />}
                                containerElement={<div style={{ height: `100vh` }} />}
                                mapElement={<div style={{ height: `100vh` }} />}
                            />
                        )}
                    </Grid>
                </Grid>
            </>
          )
      }
}



export default Delivery
