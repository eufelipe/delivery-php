import axios from 'axios'
import React, { Component } from 'react'

import Button from '@material-ui/core/Button';

import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';

import Title from '../components/Title';

class DeliveriesList extends Component {
      constructor () {
        super()
        this.state = {
          deliveries: []
        }
      }

      componentDidMount () {
        axios.get('/api/deliveries').then(response => {
          this.setState({
            deliveries: response.data
          })
        })
      }

      render () {
        const { deliveries } = this.state

          return (
               <div>

                           <Button
                                style={{ marginBottom: 30}}
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
                                <TableCell>{row.delivery_date}</TableCell>
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
