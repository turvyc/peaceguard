//
//  voltuneersMasterViewController.h
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import <UIKit/UIKit.h>

@class voltuneersDetailViewController;
@class ReportDataController;

@interface voltuneersMasterViewController : UITableViewController

@property (strong, nonatomic) voltuneersDetailViewController *detailViewController;
@property (strong, nonatomic) ReportDataController *dataController;
@end
