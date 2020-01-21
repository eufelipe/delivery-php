import axios from 'axios';
import React, { Component } from 'react';
import * as Yup from 'yup';
import { Formik, Form, Field, ErrorMessage, yupToFormErrors } from 'formik';

import {
    CssBaseline,
    Grid,
    Typography,
    FormControlLabel,
    Button,
    CircularProgress,
    Breadcrumbs,
    Link
    }
from '@material-ui/core';
import SaveIcon from '@material-ui/icons/Save';

import MuiAlert from '@material-ui/lab/Alert';

import TextField from '../components/TextField';

const required = "Campo é obrigatorio"
const max = "Máximo de caracteres é 255"
const min = "Minimo de 3 caracteres"
const date = "Formato de data inválido"

const validateForm = Yup.object().shape(
    {
        client: Yup.string().required(required).min(3, min).max(255, max),
        delivery_date: Yup.date().required(required),
        target_start: Yup.string().required(required).min(3, min).max(255, max),
        target_end: Yup.string().required(required).min(3, min).max(255, max),
    }
)

function Alert(props) {
  return <MuiAlert elevation={6} variant="filled" {...props} />;
}

class CreateDelivery extends Component {
      constructor (props) {
        super(props)
        this.state = {
          errors: '',
           isProcess: false,
        }
        this.handleCreateDelivery = this.handleCreateDelivery.bind(this)
      }

      handleCreateDelivery (values) {
        const { history } = this.props
        this.setState({isProcess: true})
        axios.post('/api/deliveries', values)
          .then(response => {
            history.push('/')
          })
          .catch(error => {
            this.setState({
              errors: error.response.data.description,
              isProcess: false
            })
          })
      }


    render () {
          return (
              <>
               <Breadcrumbs aria-label="breadcrumb">
                    <Link color="inherit" href="/">
                        Página Inícial
                    </Link>
                    <Typography color="textPrimary">Adicionar</Typography>
                </Breadcrumbs>

            <Grid container component="main" styles={styles.container}>
                <CssBaseline />
                <Grid item xs={12} sm={12} md={12} elevation={6} >

                    <Typography variant="h2" color="inherit" noWrap>
                     Adicionar nova Entrega
                    </Typography>
                    <hr />

                        <Formik
                            initialValues={{}}
                            onSubmit={this.handleCreateDelivery}
                            validationSchema={validateForm}
                        >
                            {({ errors, values, handleChange, handleBlur }) => (
                            <Form>
                                <>
                                {this.state.errors && (
                                    <Alert severity="error">{this.state.errors}</Alert>
                                )}


                                <Grid container spacing={6} style={{ marginTop: 40}}>
                                    <Grid item xs={12}>
                                    <TextField
                                        error={errors.client}
                                        name="client"
                                        label="Nome do cliente"
                                        value={values.client}
                                        handleChange={handleChange}
                                        handleBlur={handleBlur}
                                    />

                                    </Grid>
                                    <Grid item xs={12}>
                                    <TextField
                                        error={errors.delivery_date}
                                        name="delivery_date"
                                        label="Data de entrega"
                                        type="datetime-local"
                                        InputLabelProps={{ shrink: true }}
                                        value={values.delivery_date}
                                        handleChange={handleChange}
                                        handleBlur={handleBlur}
                                    />

                                    </Grid>
                                    <Grid item xs={12}>
                                    <TextField
                                        error={errors.target_start}
                                        name="target_start"
                                        label="Endereço de origem"
                                        value={values.target_start}
                                        handleChange={handleChange}
                                        handleBlur={handleBlur}
                                    />

                                    </Grid>
                                    <Grid item xs={12}>
                                    <TextField
                                        error={errors.target_end}
                                        name="target_end"
                                        label="Endereço de entrega"
                                        value={values.target_end}
                                        handleChange={handleChange}
                                        handleBlur={handleBlur}
                                    />

                                    </Grid>

                                    <Grid item xs={12}>
                                        {!this.state.isProcess && (
                                            <Button variant="contained" color="primary" size="large" type="submit" startIcon={<SaveIcon />} >
                                                Salvar entrega
                                            </Button>
                                        )}

                                         {this.state.isProcess && (
                                            <CircularProgress />
                                         )}

                                    </Grid>

                                </Grid>
                                </>
                            </Form>
                            )}
                        </Formik>
                </Grid>
            </Grid>
            </>
          )
      }
    }

const styles = {
    container: {
        height: '100vh',
    }
};

export default CreateDelivery
