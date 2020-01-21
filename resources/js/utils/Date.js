import {format, parse} from 'date-fns';

export const DateMask = {
  brDate: 'dd/MM/yyyy',
  brDayMonth: 'dd/MM',
  brDateTime: 'dd/MM/yyyy HH:mm',
  friendlyDateTime: 'dd/MM/yyyy à\\s HH:mm\\h',
  brTime: 'HH:mm',
  yearMonth: 'yyyy/MM',
  sqlDate: 'yyyy-MM-dd',
  sqlDateTime: 'yyyy-MM-dd HH:mm:ss',
  fileDateTime: 'yyyyMMddHHmmss',
  monthYear: 'MMMM/yyyy',
};

export const formatDateFromString = dateString => {
  const date = new Date(dateString);
  return formatDate(date);
};

export const formatDate = date => {
  if (!date) {
    return '';
  }

  let mDate = date;

  if (typeof date === 'string') {
    mDate = new Date(date);
  }

  try {
    const dateFormat = format(mDate, DateMask.brDate);
    const timeFormat = format(mDate, DateMask.brTime);

    return `Em ${dateFormat} às ${timeFormat}`;
  } catch (error) {
    return mDate.toString();
  }
};
