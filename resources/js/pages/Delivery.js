import axios from 'axios';
import React, { Component } from 'react';

import {
    Grid,
    CssBaseline,
    Typography,
    CircularProgress,
    Link,
    Breadcrumbs


} from '@material-ui/core';

import {formatDate} from '../utils/Date';

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
              <>
               <CssBaseline />
                <Breadcrumbs aria-label="breadcrumb">
                    <Link color="inherit" href="/">
                        Página Inícial
                    </Link>
                    <Typography color="textPrimary">Entrega</Typography>
                </Breadcrumbs>

                <Grid container component="main" styles={styles.container}>
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
            </>
          )
      }
}

export default Delivery
