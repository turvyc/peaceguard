//
//  voltuneersDetailViewController.h
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import <UIKit/UIKit.h>
@class Report;

@interface voltuneersDetailViewController : UITableViewController

@property (strong, nonatomic) Report *report;

@property (weak, nonatomic) IBOutlet UILabel *reportTitle;
@property (weak, nonatomic) IBOutlet UILabel *reportDescription;

@end
