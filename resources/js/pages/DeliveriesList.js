import axios from 'axios'
import React, { Component } from 'react'

import {
    Button,
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableRow,
    CircularProgress,

} from '@material-ui/core';

import Title from '../components/Title';
import {formatDate} from '../utils/Date'

class DeliveriesList extends Component {
      constructor () {
        super()
        this.state = {
          deliveries: [],
          isLoading: false,
        }
      }

      componentDidMount () {
        this.setState({isLoading: true})
        axios.get('/api/deliveries').then(response => {
          this.setState({
            deliveries: response.data,
             isLoading: false
          })
        })
      }

      render () {
        const { deliveries = [], isLoading = false } = this.state

        if(isLoading) {
            return <CircularProgress />
        }

          return (
               <div>
                    <Button style={{ marginBottom: 30}}
                            variant="contained"
                            color="primary"
                            href={'/create'}>
                                Adicionar Nova Entrega
                    </Button>

                    <Title>Entregas</Title>
                    <Table size="small">
                        <TableHead>
                            <TableRow>
                                <TableCell>id</TableCell>
                                <TableCell>Cliente</TableCell>
                                <TableCell>Data</TableCell>
                                <TableCell>Origem</TableCell>
                                <TableCell>Destino</TableCell>
                                <TableCell>Ações</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                        {deliveries.map(row => (
                            <TableRow key={row.id}>
                                <TableCell>{row.id}</TableCell>
                                <TableCell>{row.client}</TableCell>
                                <TableCell>{formatDate(row.delivery_date)}</TableCell>
                                <TableCell>{row.target_start}</TableCell>
                                <TableCell>{row.target_end}</TableCell>
                                <TableCell>
                                <Button
                                    variant="contained"
                                    color="primary"
                                    href={`/${row.id}`}>
                                        Visualizar
                                </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                        </TableBody>
                    </Table>
                </div>
          )
      }
}

export default DeliveriesList
