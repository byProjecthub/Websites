#!/bin/bash
# scripts/backup.sh (run via cron daily at 2 AM)

BACKUP_DIR="/backups/vueports"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="vueports_db"
RETENTION_DAYS=30

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u root -p$DB_ROOT_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# File backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/uploads /var/www/html/.env

# Upload to S3
aws s3 sync $BACKUP_DIR s3://vueports-backups/production/ --delete

# Clean old backups
find $BACKUP_DIR -type f -mtime +$RETENTION_DAYS -delete

echo "Backup completed: $DATE"