import axios from 'axios'
import React, { Component } from 'react'

import Grid from '@material-ui/core/Grid';
import CssBaseline from '@material-ui/core/CssBaseline';
import Typography from '@material-ui/core/Typography';
import CircularProgress from '@material-ui/core/CircularProgress';

import {formatDate} from '../utils/Date'


const styles = {
    container: {
        height: '100vh',
    }
};

class Delivery extends Component {
      constructor () {
        super()
        this.state = {
          delivery: [],
          isLoading: false,
        }
      }

      componentDidMount () {
        const id = this.props.match.params.id
        this.setState({isLoading: true})
        axios.get(`/api/deliveries/${id}`).then(response => {
          this.setState({
            delivery: response.data,
            isLoading: false
          })
        })
      }

      render () {
        const { delivery = [], isLoading = false } = this.state

        if(isLoading) {
            return <CircularProgress />
        }

          return (
            <Grid container component="main" styles={styles.container}>
                <CssBaseline />
                <Grid item xs={12} sm={12} md={12} elevation={6} >

                    <Typography variant="h2" color="inherit" noWrap>
                     {delivery.client}
                    </Typography>
                    <hr />

                    <Typography variant="h6" color="inherit" noWrap>
                     Data da entrega: {formatDate(delivery.delivery_date)}
                    </Typography>

                    <Typography color="inherit" noWrap>
                     Origem: <strong>{delivery.target_start}</strong> -    Destino: <strong>{delivery.target_end}</strong>
                    </Typography>

                </Grid>
            </Grid>
          )
      }
}

export default Delivery
