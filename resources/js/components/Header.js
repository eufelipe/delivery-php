import React from 'react'

import { makeStyles } from '@material-ui/core/styles';

import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import CssBaseline from '@material-ui/core/CssBaseline';


import Typography from '@material-ui/core/Typography';


import { Link } from 'react-router-dom'

const useStyles = makeStyles({
  root: {
    background: 'linear-gradient(45deg, #b71c1c 30%, #FF8E53 90%)',
    border: 0,
    borderRadius: 3,
    boxShadow: '0 3px 5px 2px rgba(255, 105, 135, .3)',
    color: 'white',
    height: 48,
    padding: '0 30px',
  },
  title: {
      color: 'white'
  }
});

const Header = () => {
 const classes = useStyles();
        return (
        <React.Fragment>
            <CssBaseline />
            <AppBar position="relative">
                <Toolbar className={classes.root}>
                <Typography variant="h6" color="inherit" noWrap>
                        <Link className={classes.title} to='/'>
                            Delivery App
                        </Link>
                </Typography>
                </Toolbar>
            </AppBar>
        </React.Fragment>
    )
}

export default Header
